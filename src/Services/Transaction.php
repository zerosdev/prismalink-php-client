<?php

namespace ZerosDev\Prismalink\Services;

use Closure;
use ZerosDev\Prismalink\Client;
use ZerosDev\Prismalink\Constant;
use ZerosDev\Prismalink\Traits\SetterGetter;

class Transaction
{
    use SetterGetter;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function submit()
    {
        $payload = $this->defined_properties;

        foreach ($payload as $name => $value) {
            if ($name == 'product_details' && is_object($value)) {
                $payload[$name] = $value->toJson();
            }
        }

        $payload = array_merge($payload, [
            'transmission_date_time' => date('Y-m-d H:i:s.v O'),
            'transaction_currency' => 'IDR',
            'merchant_key_id' => $this->client->getKeyId(),
            'merchant_id' => $this->client->getMerchantId(),
            'transaction_date_time' => date('Y-m-d H:i:s.v O'),
        ]);

        $this->client->setRequestPayload($payload);

        $jsonPayload = json_encode($this->client->getRequestPayload());

        $mac = hash_hmac('sha256', $jsonPayload, $this->client->getSecretKey());

        $this->client->addRequestHeaders('MAC', $mac);

        return $this->client->request('payment/integration/transaction/api/submit-trx', 'POST');
    }

    public function inquiry()
    {
        $payload = $this->defined_properties;

        $payload = array_merge($payload, [
            'transmission_date_time' => date('Y-m-d H:i:s.v O'),
            'merchant_key_id' => $this->client->getKeyId(),
            'merchant_id' => $this->client->getMerchantId(),
        ]);

        $this->client->setRequestPayload($payload);

        $jsonPayload = json_encode($this->client->getRequestPayload());

        $mac = hash_hmac('sha256', $jsonPayload, $this->client->getSecretKey());

        $this->client->addRequestHeaders('MAC', $mac);

        return $this->client->request('payment/integration/transaction/api/inquiry-transaction', 'POST');
    }
}
