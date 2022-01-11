<?php

namespace ZerosDev\Prismalink;

use Exception;
use Carbon\Carbon;
use GuzzleHttp\TransferStats;
use GuzzleHttp\Client as GuzzleClient;
use ZerosDev\Prismalink\Traits\SetterGetter;

class Client
{
    use SetterGetter;

    protected $http;
    protected $mode;
    protected $request_endpoint;
    protected $request_url;
    protected $request_method;
    protected $request_payload = [];
    protected $request_headers = [];
    protected $response;

    public function __construct(string $mode = 'production', string $merchant_id, string $key_id, string $secret_key)
    {
        $this->setMode($mode);
        $this->setMerchantId($merchant_id);
        $this->setkeyId($key_id);
        $this->setSecretKey($secret_key);
        $this->addRequestHeaders('Accept', 'application/json');
        $self = $this;
        $this->http = new GuzzleClient([
            'base_uri' => ($this->getMode() == 'production')
                ? Constant::URL_API_PRODUCTION
                : Constant::URL_API_DEVELOPMENT,
            'headers' => $this->getRequestHeaders(),
            'http_errors' => false,
            'on_stats' => function (TransferStats $s) use (&$self) {
                $self->setRequestUrl(strval($s->getEffectiveUri()));
            }
        ]);
    }

    public function instance()
    {
        return $this;
    }

    public function request($endpoint, $method = 'GET', $headers = [])
    {
        $method = strtolower($method);

        $this->setRequestEndpoint($endpoint);
        $this->setRequestMethod(strtoupper($method));

        foreach ($headers as $n => $v) {
            $this->addRequestHeaders($n, $v);
        }

        $options = [];

        switch ($this->getRequestMethod()) {
            case "POST":
                $this->addRequestHeaders('Content-Type', 'application/json');
                $options['json'] = $this->getRequestPayload();
                break;
        }

        $options['headers'] = $this->getRequestHeaders();

        try {
            $response = $this->http->{$method}($endpoint, $options)
                ->getBody()
                ->getContents();
        } catch (Exception $e) {
            $response = $e->getMessage();
        }

        $this->setResponse($response);

        return $this->getResponse();
    }

    public function debugs()
    {
        return [
            'url'	=> $this->getRequestUrl(),
            'method' => $this->getRequestMethod(),
            'payload' => $this->getRequestPayload(),
            'headers' => $this->getRequestHeaders(),
            'response' => $this->getResponse(),
        ];
    }
}
