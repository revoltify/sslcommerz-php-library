<?php

namespace SSLCommerz;

use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Request;
use SSLCommerz\Exceptions\SSLCommerzException;

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
        $this->request = Request::createFromGlobals();
        $this->store_id = $store_id;
        $this->store_password = $store_password;
        $base_url = $sandbox ? 'https://sandbox.sslcommerz.com/' : 'https://securepay.sslcommerz.com/';
        $this->client = new Client(['base_uri' => $base_url]);
    }

    /**
     * Initiate a payment request.
     *
     * @param PaymentParams $params
     * @return array
     * @throws SSLCommerzException
     */
    public function initiatePayment(PaymentParams $params)
    {
        $data = array_merge([
            'store_id'     => $this->store_id,
            'store_passwd' => $this->store_password,
        ], $params->getParams());

        $response = $this->client->post('gwprocess/v4/api.php', [
            'form_params' => $data,
        ]);

        $result = json_decode($response->getBody(), true);

        if (isset($result['status']) && $result['status'] === 'SUCCESS') {
            return $result;
        }

        throw new SSLCommerzException("Payment initiation failed: " . $result['failedreason']);
    }

    /**
     * Validate a payment transaction.
     *
     * @param string $val_id
     * @return array
     * @throws SSLCommerzException
     */
    public function validatePayment($val_id = null)
    {
        if (is_null($val_id)) {
            $val_id = $this->request->get('val_id');
        }

        $response = $this->client->get('validator/api/validationserverAPI.php', [
            'query' => [
                'store_id'     => $this->store_id,
                'store_passwd' => $this->store_password,
                'val_id'      => $val_id,
            ],
        ]);

        return $result = json_decode($response->getBody(), true);

        if (isset($result['element'][0]['status']) && ($result['element'][0]['status'] === 'VALIDATED' || $result['element'][0]['status'] === 'VALID')) {

            return $result['element'][0];
        }

        // Handle cases where validation fails or response is not as expected
        $errorReason = isset($result['failedreason']) ? $result['failedreason'] : 'Unknown error';
        throw new SSLCommerzException("Payment validation failed: " . $errorReason);
    }

    /**
     * Refund a payment transaction.
     *
     * @param string $bank_tran_id
     * @param float $refund_amount
     * @param string|null $refund_remarks
     * @return array
     * @throws SSLCommerzException
     */
    public function refundPayment($bank_tran_id, $refund_amount, $refund_remarks = null)
    {
        $response = $this->client->get('validator/api/merchantTransIDvalidationAPI.php', [
            'query' => [
                'store_id'       => $this->store_id,
                'store_passwd'   => $this->store_password,
                'bank_tran_id'   => $bank_tran_id,
                'refund_amount'  => $refund_amount,
                'refund_remarks' => $refund_remarks,
            ],
        ]);

        $result = json_decode($response->getBody(), true);

        if (isset($result['status']) && $result['status'] === 'success') {
            return $result;
        }

        throw new SSLCommerzException("Refund failed: " . $result['errorReason']);
    }
}
