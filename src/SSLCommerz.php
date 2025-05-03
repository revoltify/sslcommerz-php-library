<?php

namespace SSLCommerz;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use SSLCommerz\Exception\SSLCommerzException;
use SSLCommerz\Response\CheckoutResponse;
use SSLCommerz\Response\RefundResponse;
use SSLCommerz\Response\VerifyResponse;

class SSLCommerz
{
    private $store_id;
    private $store_password;
    private $client;
    private $request;

    /**
     * SSLCommerz constructor.
     *
     * @param string $store_id
     * @param string $store_password
     * @param bool $sandbox
     */
    public function __construct($store_id, $store_password, $sandbox = false)
    {
        $this->request = $_REQUEST;
        $this->store_id = $store_id;
        $this->store_password = $store_password;
        $base_url = $sandbox ? 'https://sandbox.sslcommerz.com/' : 'https://securepay.sslcommerz.com/';
        $this->client = new Client(['base_uri' => $base_url, 'timeout' => 10]);
    }

    /**
     * Initiate a payment request.
     *
     * @param PaymentParams $params
     * @return \SSLCommerz\Response\CheckoutResponse
     * @throws SSLCommerzException
     */
    public function initiatePayment(PaymentParams $params): CheckoutResponse
    {
        $response = $this->sendRequest('POST', 'gwprocess/v4/api.php', [
            'form_params' => array_merge([
                'store_id' => $this->store_id,
                'store_passwd' => $this->store_password,
            ], $params->getParams()),
        ]);

        return new CheckoutResponse($response);
    }

    /**
     * Validate a payment transaction.
     *
     * @param string $val_id
     * @return \SSLCommerz\Response\VerifyResponse
     * @throws SSLCommerzException
     */
    public function validatePayment(?string $val_id = null): VerifyResponse
    {
        $val_id = $this->resolveValId($val_id);

        $response = $this->sendRequest('GET', 'validator/api/validationserverAPI.php', [
            'query' => [
                'store_id' => $this->store_id,
                'store_passwd' => $this->store_password,
                'val_id' => $val_id,
            ],
        ]);

        return new VerifyResponse($response);
    }

    /**
     * Refund a payment transaction.
     *
     * @param string $bank_tran_id
     * @param int|float|string $refund_amount
     * @param string $refund_remarks
     * @return \SSLCommerz\Response\RefundResponse
     * @throws SSLCommerzException
     */
    public function refundPayment(string $bank_tran_id, $refund_amount, string $refund_remarks): RefundResponse
    {
        $response = $this->sendRequest('GET', 'validator/api/merchantTransIDvalidationAPI.php', [
            'query' => [
                'store_id' => $this->store_id,
                'store_passwd' => $this->store_password,
                'bank_tran_id' => $bank_tran_id,
                'refund_amount' => $refund_amount,
                'refund_remarks' => $refund_remarks,
            ],
        ]);

        return new RefundResponse($response);
    }

    /**
     * Resolve Validation ID
     *
     * @param string $val_id
     * @return string
     * @throws SSLCommerzException
     */
    private function resolveValId(?string $val_id = null): string
    {
        if (!empty($val_id)) {
            return $val_id;
        }

        if (!empty($this->request['val_id'])) {
            return $this->request['val_id'];
        }

        throw new SSLCommerzException('Validation ID is missing.');
    }

    /**
     * Sends an HTTP request to the SSL API and processes the response.
     *
     * @param string $method Request method
     * @param string $endpoint The Endpoint to which the request is sent
     * @param array  $payload  The data to be sent in the request
     * @return array The parsed response data from the API
     * @throws IBBLException If the HTTP response is not successful or cannot be parsed
     */
    private function sendRequest(string $method, string $endpoint, array $options): array
    {
        try {
            // Send the POST request to the specified Endpoints
            $response = $this->client->request($method, $endpoint, $options);

            // If the HTTP status code is not 200 (OK), throw an exception
            if ($response->getStatusCode() !== 200) {
                throw new SSLCommerzException('Unexpected HTTP status code: ' . $response->getStatusCode());
            }

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            throw new SSLCommerzException('HTTP Client error: ' . $e->getMessage());
        } catch (\Exception $e) {
            throw new SSLCommerzException('Unexpected error: ' . $e->getMessage());
        }
    }
}
