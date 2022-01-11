<?php

require './vendor/autoload.php';

use ZerosDev\Prismalink\Client;
use ZerosDev\Prismalink\Components\ProductDetails;

$merchant_id = '';
$key_id = '';
$secret_key = '';

$client = new Client('development', $merchant_id, $key_id, $secret_key);

$submit = $client->transaction()
    ->setMerchantRefNo("61dbfc41cdee9")
    ->setBackendCallbackUrl('https://tripay.co.id/callback/prismalink')
    ->setFrontendCallbackUrl('https://www.prismalink.co.id/')
    ->setUserDeviceId("61dbfc41cdef7")
    ->setUserIpAddress("::1")
    ->setProductDetails(function (ProductDetails $product) {
        $product->add('P1', 'Nama Produk', 1, '10000');
    })
    ->setInvoiceNumber("61dbfc41ce000")
    ->setTransactionAmount(10000)
    ->setPaymentMethod('VA')
    ->setIntegrationType('02')
    ->submit();

print_r($client->debugs());
