<?php

namespace SSLCommerz;

class PaymentParams
{
    private $params = [];

    public function setAmount($amount)
    {
        $this->params['total_amount'] = $amount;
        return $this;
    }

    public function setCurrency($currency)
    {
        $this->params['currency'] = $currency;
        return $this;
    }

    public function setTransactionId($tran_id)
    {
        $this->params['tran_id'] = $tran_id;
        return $this;
    }

    public function setSuccessUrl($url)
    {
        $this->params['success_url'] = $url;
        return $this;
    }

    public function setFailUrl($url)
    {
        $this->params['fail_url'] = $url;
        return $this;
    }

    public function setCancelUrl($url)
    {
        $this->params['cancel_url'] = $url;
        return $this;
    }

    public function setCustomerInfo($name, $email, $phone, $address1, $city, $country)
    {
        $this->params['cus_name'] = $name;
        $this->params['cus_email'] = $email;
        $this->params['cus_phone'] = $phone;
        $this->params['cus_add1'] = $address1;
        $this->params['cus_city'] = $city;
        $this->params['cus_country'] = $country;
        return $this;
    }

    public function setProductInfo($name, $category, $profile = 'general')
    {
        $this->params['shipping_method'] = 'NO';
        $this->params['product_name'] = $name;
        $this->params['product_category'] = $category;
        $this->params['product_profile'] = $profile;
        return $this;
    }

    public function setCustomValues($value_a = null, $value_b = null, $value_c = null, $value_d = null)
    {
        $this->params['value_a'] = $value_a;
        $this->params['value_b'] = $value_b;
        $this->params['value_c'] = $value_c;
        $this->params['value_d'] = $value_d;
        return $this;
    }

    public function getParams()
    {
        return $this->params;
    }
}
