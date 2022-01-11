<h1 align="center">durianpay-php-client</h1>
<h6 align="center"></h6>

<p align="center">
  <img src="https://img.shields.io/github/v/release/ZerosDev/durianpay-php-client?include_prereleases" alt="release"/>
  <img src="https://img.shields.io/github/languages/top/ZerosDev/durianpay-php-client" alt="language"/>
  <img src="https://img.shields.io/github/license/ZerosDev/durianpay-php-client" alt="license"/>
  <img src="https://img.shields.io/github/languages/code-size/ZerosDev/durianpay-php-client" alt="size"/>
  <img src="https://img.shields.io/github/downloads/ZerosDev/durianpay-php-client/total" alt="downloads"/>
  <img src="https://img.shields.io/badge/PRs-welcome-brightgreen.svg" alt="pulls"/>
</p>

## About

This library give you an easy way to call DurianPay API in elegant code style. Example :

```php
Durianpay::orders()->fetch();
```
```php
Durianpay::payments()
    ->setType('VA')
    ->setRequest(function (Request $request) {
        $request->setOrderId('ord_JGytr64yGj8')
            ->setBankCode('XXX')
            ->setName('Nama Pelanggan')
            ->setAmount(10000);
    })
    ->charge()
```

## Installation

1. Run command
<pre><code>composer require zerosdev/durianpay-php-client</code></pre>

2. Run command
<pre><code>composer dump-autoload</code></pre>

### The following steps only needed if you are using Laravel

3. Then
<pre><code>php artisan vendor:publish --provider="ZerosDev\Durianpay\Laravel\ServiceProvider"</code></pre>

4. Edit **config/durianpay.php** and put your API credentials
    
## Usage

### Laravel

```php
<?php

namespace App\Http\Controllers;

use Durianpay;
use ZerosDev\Durianpay\Components\Customer\Customer;
use ZerosDev\Durianpay\Components\Customer\Adress;
use ZerosDev\Durianpay\Components\Customer\Info;
use ZerosDev\Durianpay\Components\Items;
use ZerosDev\Durianpay\Components\Metadata;

class YourController extends Controller
{
    public function index()
    {
        $order = Durianpay::orders()
            ->setAmount(10000)
            ->setPaymentOption('full_payment')
            ->setCurrency('IDR')
            ->setOrderRefId("123456")
            ->setCustomer(function (Customer $customer) {
                $customer->setEmail('email@customer.com')
                    ->setAddress(function (Address $address) {
                        $address->setReceiverName('Nama Penerima');
                    });
            })
            ->setItems(function (Items $items) {
                $items->add('Nama Produk', 10000, 1, 'https://google.com/product.jpg');
            })
            ->setMetadata(function (Metadata $metadata) {
                $metadata->setMerchantRef('123456789');
            })
            ->create();
            
        dd($order);
    }
}
```

### Non-Laravel

```php
<?php

require 'path/to/your/vendor/autoload.php';

use ZerosDev\Durianpay\Client;
use ZerosDev\Durianpay\Components\Customer\Customer;
use ZerosDev\Durianpay\Components\Customer\Adress;
use ZerosDev\Durianpay\Components\Customer\Info;
use ZerosDev\Durianpay\Components\Items;
use ZerosDev\Durianpay\Components\Metadata;

$durianpay = new Client('your_api_key_here');

$order = $durianpay->orders()
    ->setAmount(10000)
    ->setPaymentOption('full_payment')
    ->setCurrency('IDR')
    ->setOrderRefId("123456")
    ->setCustomer(function (Customer $customer) {
        $customer->setEmail('email@customer.com')
            ->setAddress(function (Address $address) {
                $address->setReceiverName('Nama Penerima');
            });
    })
    ->setItems(function (Items $items) {
        $items->add('Nama Produk', 10000, 1, 'https://google.com/product.jpg');
    })
    ->setMetadata(function (Metadata $metadata) {
        $metadata->setMerchantRef('123456789');
    })
    ->create();
    
print_r($order);
```
