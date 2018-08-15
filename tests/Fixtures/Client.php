<?php

namespace Netatmo\Tests\Fixtures;

use Netatmo\OAuth2;

class Client
{
    public static function withResponses($responses)
    {
        $oauth2Config = new OAuth2\Config("id", "secret");
        $client = new \Netatmo\Client($oauth2Config);
        $httpClient = new Http\Client($responses);
        $client->setHttpClient($httpClient);
        $client->setAccessToken(new OAuth2\Token("000|netatmo"));
        return $client;
    }
}
