<?php

require '../vendor/autoload.php';

use ZerosDev\Prismalink\Client;
use ZerosDev\Prismalink\Components\ProductDetails;

$mode = 'development';
$merchant_id = '';
$key_id = '';
$secret_key = '';

$client = new Client($mode, $merchant_id, $key_id, $secret_key);

$merchantRefNo = '61dbfc41cdee9';
$invoiceNumber = '61dbfc41ce000';
$userDeviceId = '61dbfc41cdef7';

$submit = $client->transaction()
    ->setMerchantRefNo($merchantRefNo)
    ->setBackendCallbackUrl('https://yourdomain.com/callback-prismalink')
    ->setFrontendCallbackUrl('https://www.prismalink.co.id/')
    ->setUserDeviceId($userDeviceId)
    ->setUserIpAddress($_SERVER['REMOTE_ADDR'])
    ->setProductDetails(function (ProductDetails $product) {
        $product->add('P1', 'Nama Produk', 1, 10000);
    })
    ->setInvoiceNumber($invoiceNumber)
    ->setTransactionAmount(10000)
    ->setPaymentMethod('VA')
    ->setIntegrationType('02')
    ->submit();

print_r($client->debugs());
