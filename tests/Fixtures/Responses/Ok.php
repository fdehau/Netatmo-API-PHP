<?php

namespace Netatmo\Sdk\Tests\Fixtures\Responses;

class Ok extends Json
{
    public function __construct($body)
    {
        parent::__construct(
            200,
            [
                'status' => 'ok',
                'body' => $body,
                'time_server' => time(),
                'time_exec' => 0.2
            ]
        );
    }
}
