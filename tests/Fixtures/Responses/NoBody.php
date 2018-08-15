<?php

namespace Netatmo\Tests\Fixtures\Responses;

use GuzzleHttp\Psr7\Response;

class NoBody extends Response
{
    public function __construct($status)
    {
        parent::__construct($status);
    }
}
