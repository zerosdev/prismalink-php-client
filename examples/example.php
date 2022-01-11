<?php

require '../vendor/autoload.php';

use ZerosDev\Durianpay\Client;
use ZerosDev\Durianpay\Components\Customer\Customer;
use ZerosDev\Durianpay\Components\Customer\Address as CustomerAddress;
use ZerosDev\Durianpay\Components\Customer\Info as CustomerInfo;
use ZerosDev\Durianpay\Components\Items;
use ZerosDev\Durianpay\Components\Metadata;
use ZerosDev\Durianpay\Components\Request;

$apiKey = "your_api_key_here";

$client = new Client($apiKey);

/**
 * Make an order
 * */

$order = $client->orders()
    ->setAmount(10000)
    ->setPaymentOption('full_payment')
    ->setCurrency('IDR')
    ->setOrderRefId(uniqid())
    ->setCustomer(function (Customer $customer) {
        $customer->setEmail('email@customer.com')
            ->setAddress(function (CustomerAddress $address) {
                $address->setReceiverName('Nama Penerima');
            });
    })
    ->setItems(function (Items $items) {
        $items->add('Nama Produk', 10000, 1, 'https://google.com/product.jpg');
    })
    ->setMetadata(function (Metadata $metadata) {
        $metadata->setTes('value');
    })
    ->create();

/**
 * Fetch all orders
 * */

$orders = $client->orders()->fetch();

/**
 * Fetch an order by id
 * */

$fetch = $client->orders()->setId('ord_JGytr64yGj8')->fetch();

/**
 * Charge a payment/create payment code
 * */

$charge = $client->payments()
    ->setType('VA')
    ->setRequest(function (Request $request) {
        $request->setOrderId('ord_JGytr64yGj8')
            ->setBankCode('BRI')
            ->setName('Nama')
            ->setAmount(10000);
    })
    ->charge();

/**
 * Fetch all payments
 **/

$payments = $client->payments()->fetch();

/**
 * Fetch payment by id
 **/

$fetch = $client->payments()->setId('pay_JGytr64yGj8')->fetch();
