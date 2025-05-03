<?php

namespace SSLCommerz\Response;

class VerifyResponse
{
    protected ?array $data = null;

    public function __construct(?array $data = null)
    {
        $this->data = $data;
    }

    /**
     * Get the status of the payment response in lowercase.
     */
    public function status(): ?string
    {
        return isset($this->data['status']) ? strtolower($this->data['status']) : null;
    }

    /**
     * Determine if the payment was successful.
     */
    public function success(): bool
    {
        return $this->status() === 'valid' || $this->status() === 'validated';
    }

    /**
     * Determine if the payment failed.
     */
    public function failed(): bool
    {
        return $this->status() === 'invalid_transaction';
    }

    /**
     * Get the validation ID of the payment response.
     */
    public function valId(): ?string
    {
        return $this->data['val_id'] ?? null;
    }

    /**
     * Get the transaction date of the payment response.
     */
    public function tranDate(): ?string
    {
        return $this->data['tran_date'] ?? null;
    }

    /**
     * Get the transacion id of the payment response.
     */
    public function tranId(): ?string
    {
        return $this->data['tran_id'] ?? null;
    }

    /**
     * Get the amount of the payment response.
     */
    public function amount(): ?string
    {
        return $this->data['amount'] ?? null;
    }

    /**
     * Get the store amount of the payment response.
     */
    public function storeAmount(): ?string
    {
        return $this->data['store_amount'] ?? null;
    }

    /**
     * Get the currency of the payment response.
     */
    public function currency(): ?string
    {
        return $this->data['currency'] ?? null;
    }

    /**
     * Get the bank transaction ID of the payment response.
     */
    public function bankTranId(): ?string
    {
        return $this->data['bank_tran_id'] ?? null;
    }

    /**
     * Get the card type of the payment response.
     */
    public function cardType(): ?string
    {
        return $this->data['card_type'] ?? null;
    }

    /**
     * Get the card number of the payment response.
     */
    public function cardNo(): ?string
    {
        return $this->data['card_no'] ?? null;
    }

    /**
     * Get the card issuer of the payment response.
     */
    public function cardIssuer(): ?string
    {
        return $this->data['card_issuer'] ?? null;
    }

    /**
     * Get the card brand of the payment response.
     */
    public function cardBrand(): ?string
    {
        return $this->data['card_brand'] ?? null;
    }

    /**
     * Get the card issuer country of the payment response.
     */
    public function cardIssuerCountry(): ?string
    {
        return $this->data['card_issuer_country'] ?? null;
    }

    /**
     * Get the card issuer country code of the payment response.
     */
    public function cardIssuerCountryCode(): ?string
    {
        return $this->data['card_issuer_country_code'] ?? null;
    }

    /**
     * Get the currency type of the payment response.
     */
    public function currencyType(): ?string
    {
        return $this->data['currency_type'] ?? null;
    }

    /**
     * Get the currency amount of the payment response.
     */
    public function currencyAmount(): ?string
    {
        return $this->data['currency_amount'] ?? null;
    }

    /**
     * Get the currency rate of the payment response.
     */
    public function currencyRate(): ?string
    {
        return $this->data['currency_rate'] ?? null;
    }

    /**
     * Get the base fair of the payment response.
     */
    public function baseFair(): ?string
    {
        return $this->data['base_fair'] ?? null;
    }

    /**
     * Get the value A of the payment response.
     */
    public function valueA(): ?string
    {
        return $this->data['value_a'] ?? null;
    }

    /**
     * Get the value B of the payment response.
     */
    public function valueB(): ?string
    {
        return $this->data['value_b'] ?? null;
    }

    /**
     * Get the value C of the payment response.
     */
    public function valueC(): ?string
    {
        return $this->data['value_c'] ?? null;
    }

    /**
     * Get the value D of the payment response.
     */
    public function valueD(): ?string
    {
        return $this->data['value_d'] ?? null;
    }

    /**
     * Get the EMI installment of the payment response.
     */
    public function emiInstalment(): ?string
    {
        return $this->data['emi_instalment'] ?? null;
    }

    /**
     * Get the EMI amount of the payment response.
     */
    public function emiAmount(): ?string
    {
        return $this->data['emi_amount'] ?? null;
    }

    /**
     * Get the EMI description of the payment response.
     */
    public function emiDescription(): ?string
    {
        return $this->data['emi_description'] ?? null;
    }

    /**
     * Get the EMI issuer of the payment response.
     */
    public function emiIssuer(): ?string
    {
        return $this->data['emi_issuer'] ?? null;
    }

    /**
     * Get the account details of the payment response.
     */
    public function accountDetails(): ?string
    {
        return $this->data['account_details'] ?? null;
    }

    /**
     * Get the risk title of the payment response.
     */
    public function riskTitle(): ?string
    {
        return $this->data['risk_title'] ?? null;
    }

    /**
     * Get the risk level of the payment response.
     */
    public function riskLevel(): ?string
    {
        return $this->data['risk_level'] ?? null;
    }

    /**
     * Get the raw response.
     */
    public function toArray(): ?array
    {
        return $this->data;
    }
}
