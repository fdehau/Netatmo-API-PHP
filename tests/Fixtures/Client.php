<?php

namespace Netatmo\Sdk\Tests\Fixtures;

use Netatmo\Sdk\OAuth2;
use Netatmo\Sdk\Config;

class Client
{
    public static function withResponses($responses)
    {
        $config = Config::fromArray([
            "oauth2" => [
                "client_id" => "id",
                "client_secret" => "secret"
            ]
        ]);
        $client = new \Netatmo\Sdk\Client($config);
        $httpClient = new Http\Client($responses);
        $client->setHttpClient($httpClient);
        $client->setAccessToken(new OAuth2\Token("000|netatmo"));
        return $client;
    }
}
