<?php

namespace Netatmo\Sdk\Tests\Fixtures\Responses\OAuth2;

use Netatmo\Sdk\Tests\Fixtures\Responses;

class Error extends Responses\Json
{
    public function __construct($status, $error, $description = "")
    {
        $body = [
            'error' => $error,
        ];
        if (!empty($description)) {
            $body['error_description'] = $description;
        }
        parent::__construct($status, $body);
    }
}
