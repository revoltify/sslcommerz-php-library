# SSLCommerz PHP Library

This is a PHP library for integrating the SSLCommerz payment gateway. It provides a simple and easy-to-use interface for processing payments via SSLCommerz in your PHP application.

## Features

- Simple integration with SSLCommerz payment gateway
- Easy-to-use API for payment processing
- Support for both sandbox and live environments
- Secure transaction handling
- Refund processing
- Detailed documentation

## Installation

To install the library, use Composer:

```bash
composer require revoltify/sslcommerz-php-library
```

## Usage

### 1. Initiating a Payment

You can create a new payment session by initializing the `SSLCommerz` class and providing the necessary payment details.

```php
<?php

require 'vendor/autoload.php';

use SSLCommerz\Exceptions\SSLCommerzException;
use SSLCommerz\PaymentParams;
use SSLCommerz\SSLCommerz;

try {
    // Initialize SSLCommerz with your store ID, store password, and sandbox mode
    $sslcommerz = new SSLCommerz('your_store_id', 'your_store_password', true);

    // Set up payment parameters
    $params = (new PaymentParams())
        ->setAmount(1000)  // Amount in BDT
        ->setCurrency('BDT')
        ->setTransactionId(uniqid())  // Unique transaction ID
        ->setSuccessUrl('https://yourdomain.com/success.php')
        ->setFailUrl('https://yourdomain.com/fail.php')
        ->setCancelUrl('https://yourdomain.com/cancel.php')
        ->setCustomerInfo('Customer Name', 'customer@example.com', '01700000000', 'Customer Address', 'Dhaka', 'Bangladesh')
        ->setProductInfo('Product Name', 'Electronics', 'general')
        ->setCustomValues('Ref001', 'Ref002', 'Ref003', 'Ref004');

    // Initiate payment and get the response
    $response = $sslcommerz->initiatePayment($params);

    // Redirect to the payment gateway
    header("location:" . $response['GatewayPageURL']);

} catch (SSLCommerzException $e) {
    // Handle any errors that occur during the payment initiation
    echo $e->getMessage();
}
```

### 2. Validating a Payment

After the payment is processed, SSLCommerz sends a notification to your server. You can validate the payment using the following code:

```php
<?php

require 'vendor/autoload.php';

use SSLCommerz\Exceptions\SSLCommerzException;
use SSLCommerz\SSLCommerz;

try {
    // Initialize SSLCommerz with your store ID, store password, and sandbox mode
    $sslcommerz = new SSLCommerz('your_store_id', 'your_store_password', true);
    
    // Validate the payment
    $response = $sslcommerz->validatePayment();
    
    // Output the validation response
    echo "<pre>";
    print_r($response);

} catch (SSLCommerzException $e) {
    // Handle any errors during payment validation
    echo $e->getMessage();
}
```

### 3. Handling IPN (Instant Payment Notification)

SSLCommerz sends an IPN (Instant Payment Notification) to your server after the payment is completed. You can handle this notification and validate the payment using the following code:

```php
<?php

require 'vendor/autoload.php';

use SSLCommerz\Exceptions\SSLCommerzException;
use SSLCommerz\SSLCommerz;

try {
    // Initialize SSLCommerz with your store ID, store password, and sandbox mode
    $sslcommerz = new SSLCommerz('your_store_id', 'your_store_password', true);
    
    // Validate the payment received via IPN
    $response = $sslcommerz->validatePayment();
    
    // Output the IPN validation response
    echo "<pre>";
    print_r($response);

} catch (SSLCommerzException $e) {
    // Handle any errors during IPN validation
    echo $e->getMessage();
}
```


### 4. Refunding a Payment

You can process a refund for a payment transaction by using the `refundPayment` method. Here's an example:

```php
<?php

require 'vendor/autoload.php';

use SSLCommerz\Exceptions\SSLCommerzException;
use SSLCommerz\SSLCommerz;

try {
    // Initialize SSLCommerz with your store ID, store password, and sandbox mode
    $sslcommerz = new SSLCommerz('your_store_id', 'your_store_password', true);

    // Refund a payment
    $bank_tran_id = 'TRANSACTION_ID';  // Replace with the actual bank_tran_id
    $refund_amount = 500;  // Amount to refund in BDT
    $refund_remarks = 'Customer request for refund';  // Optional refund remarks

    $response = $sslcommerz->refundPayment($bank_tran_id, $refund_amount, $refund_remarks);
    
    // Output the refund response
    echo "<pre>";
    print_r($response);

} catch (SSLCommerzException $e) {
    // Handle any errors that occur during the refund process
    echo $e->getMessage();
}
```

## Contribution

Contributions are welcome! If you find any issues or have any feature requests, please open an issue or submit a pull request.

## License

This library is open-sourced software licensed under the MIT license.