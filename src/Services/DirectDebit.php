<?php

namespace ZerosDev\Prismalink\Services;

use Closure;
use ZerosDev\Prismalink\Client;
use ZerosDev\Prismalink\Constant;
use ZerosDev\Prismalink\Traits\SetterGetter;

class DirectDebit
{
    use SetterGetter;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function request()
    {
        $payload = $this->defined_properties;

        $payload = array_merge($payload, [
            'transmission_date_time' => date('Y-m-d H:i:s.v O'),
        ]);

        $this->client->setRequestPayload($payload);

        $jsonPayload = json_encode($this->client->getRequestPayload());

        $mac = hash_hmac('sha256', $jsonPayload, $this->client->getSecretKey());

        $this->client->addRequestHeaders('MAC', $mac);

        return $this->client->request('debitin/directdebitrequest', 'POST');
    }

    public function confirmation($session_token)
    {
        $payload = $this->defined_properties;

        $payload = array_merge($payload, [
            'transmission_date_time' => date('Y-m-d H:i:s.v O'),
        ]);

        $this->client->setRequestPayload($payload);

        $jsonPayload = json_encode($this->client->getRequestPayload());

        $mac = hash_hmac('sha256', $jsonPayload, $this->client->getSecretKey());

        $this->client->addRequestHeaders('MAC', $mac);
        $this->client->addRequestHeaders('session_token', $session_token);

        return $this->client->request('debitin/directdebitconfirmation', 'POST');
    }

    public function unbind()
    {
        $payload = $this->defined_properties;

        $payload = array_merge($payload, [
            'transmission_date_time' => date('Y-m-d H:i:s.v O'),
        ]);

        $this->client->setRequestPayload($payload);

        $jsonPayload = json_encode($this->client->getRequestPayload());

        $mac = hash_hmac('sha256', $jsonPayload, $this->client->getSecretKey());

        $this->client->addRequestHeaders('MAC', $mac);

        return $this->client->request('debitin/unbind', 'POST');
    }

    public function changeLimit()
    {
        $payload = $this->defined_properties;

        $payload = array_merge($payload, [
            'transmission_date_time' => date('Y-m-d H:i:s.v O'),
        ]);

        $this->client->setRequestPayload($payload);

        $jsonPayload = json_encode($this->client->getRequestPayload());

        $mac = hash_hmac('sha256', $jsonPayload, $this->client->getSecretKey());

        $this->client->addRequestHeaders('MAC', $mac);

        return $this->client->request('debitin/change-limit', 'POST');
    }
}
