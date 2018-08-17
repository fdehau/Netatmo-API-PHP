<?php

namespace Netatmo\Sdk\Tests\Fixtures;

use Netatmo\Sdk\OAuth2;

class Client
{
    public static function withResponses($responses)
    {
        $oauth2Config = new OAuth2\Config("id", "secret");
        $client = new \Netatmo\Sdk\Client($oauth2Config);
        $httpClient = new Http\Client($responses);
        $client->setHttpClient($httpClient);
        $client->setAccessToken(new OAuth2\Token("000|netatmo"));
        return $client;
    }
}
