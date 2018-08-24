<?php

namespace Netatmo\Sdk\Tests\Fixtures\Http;

use Netatmo\Sdk\Http;
use GuzzleHttp;
use Psr\Http\Message\RequestInterface;

class Client implements Http\Client
{
    private $responses = [];
    private $history = [];

    public function __construct($responses)
    {
        $this->responses = array_reverse($responses);
    }

    public function getHistory()
    {
        return $this->history;
    }

    public function getRequests()
    {
        return array_map(
            function ($item) {
                return $item['request'];
            },
            $this->history
        );
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
        $mock = new GuzzleHttp\Handler\MockHandler([$response]);
        $stack = GuzzleHttp\HandlerStack::create($mock);
        $history = GuzzleHttp\Middleware::history($this->history);
        $stack->push($history);
        $client = new GuzzleHttp\Client(['handler' => $stack]);
        return $client->send($request, [
            'timeout' => $options->getTimeout(),
            'http_errors' => false
        ]);
    }
}
