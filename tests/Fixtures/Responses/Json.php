<?php

namespace Netatmo\Sdk\Tests\Fixtures\Responses;

use GuzzleHttp\Psr7\Response;

class Json extends Response
{
    public function __construct($status, $body)
    {
        if (is_array($body)) {
            $body = json_encode($body);
        }
        parent::__construct(
            $status,
            [
                'Content-Encoding' => 'application/json'
            ],
            $body
        );
    }
}
