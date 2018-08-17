<?php

namespace Netatmo\Sdk\Tests\Fixtures\Responses\OAuth2;

use Netatmo\Sdk\Tests\Fixtures\Responses;

class Error extends Responses\Json
{
    public function __construct($status, $error)
    {
        $body = [
            'error' => $error
        ];
        parent::__construct($status, $body);
    }
}
