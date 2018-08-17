<?php

namespace Netatmo\Sdk\Http;

use GuzzleHttp;
use Psr\Http\Message\RequestInterface;

class GuzzleClient implements Client
{
    private $client = null;

    public function __construct()
    {
        $this->client = new GuzzleHttp\Client();
    }

    public function getRequest($method, $uri)
    {
        return new GuzzleHttp\Psr7\Request($method, $uri);
    }

    public function send(RequestInterface $request, Options $options)
    {
        return $this->client->send($request, [
            "timeout" => $options->getTimeout(),
            "http_errors" => false
        ]);
    }
}
