<?php

namespace Netatmo\Tests\Fixtures\Responses;

class Ok extends Json
{
    public function __construct($body)
    {
        parent::__construct(
            200,
            [
                'status' => 'ok',
                'body' => $body
            ]
        );
    }
}
