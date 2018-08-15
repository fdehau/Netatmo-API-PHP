<?php

namespace Netatmo\Tests\Fixtures\Http;

use Netatmo\Http;
use GuzzleHttp;
use Psr\Http\Message\RequestInterface;

class Client implements Http\Client
{
    private $responses = [];

    public function __construct($responses)
    {
        $this->responses = array_reverse($responses);
    }

    public function getRequest($method, $uri)
    {
        return new GuzzleHttp\Psr7\Request($method, $uri);
    }

    public function send(RequestInterface $request, Http\Options $options)
    {
        $response = array_pop($this->responses);
        if (is_null($response)) {
            throw new \OutofBoundsException("No more responses");
        }
        $handler = new GuzzleHttp\Handler\MockHandler([$response]);
        $stack = GuzzleHttp\HandlerStack::create($handler);
        $client = new GuzzleHttp\Client(['handler' => $stack]);
        return $client->send($request, [
            'timeout' => $options->getTimeout(),
            'http_errors' => false
        ]);
    }
}
