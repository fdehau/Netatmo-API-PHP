<?php

namespace Netatmo\Sdk\Http;

use Psr\Http\Message\RequestInterface;

interface Client
{
    public function getRequest($method, $uri);

    public function send(RequestInterface $request, Options $options);
}
