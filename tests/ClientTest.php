<?php

namespace Netatmo\Tests;

use Netatmo\Client;
use Netatmo\Http;
use Netatmo\OAuth2;
use Netatmo\ErrorCode;
use Netatmo\Requests;
use Netatmo\Tests\Fixtures;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    /**
     * @expectedException \Netatmo\Exceptions\Error
     */
    public function testGetTokensFailWithNoBody()
    {
        $oauth2Config = new OAuth2\Config("id", "secret");
        $client = new Client($oauth2Config);
        $httpClient = new Fixtures\Client([
            new Fixtures\Responses\NoBody(400)
        ]);
        $client->setHttpClient($httpClient);
        $grant = new OAuth2\Grants\Password("user@access.com", "password");
        $res = $client->getTokens($grant);
    }

    /**
     * @expectedException \Netatmo\Exceptions\Error
     */
    public function testGetTokensFailWithInvalidJson()
    {
        $oauth2Config = new OAuth2\Config("id", "secret");
        $client = new Client($oauth2Config);
        $httpClient = new Fixtures\Client([
            new Fixtures\Responses\Json(400, "{")
        ]);
        $client->setHttpClient($httpClient);
        $grant = new OAuth2\Grants\Password("user@access.com", "password");
        $res = $client->getTokens($grant);
    }

    /**
     * @expectedException \Netatmo\Exceptions\OAuth2Error
     */
    public function testGetTokensFailWithOAuth2Error()
    {
        $oauth2Config = new OAuth2\Config("id", "secret");
        $client = new Client($oauth2Config);
        $httpClient = new Fixtures\Client([
            new Fixtures\Responses\OAuth2\Error(400, "invalid_token")
        ]);
        $client->setHttpClient($httpClient);
        $grant = new OAuth2\Grants\Password("user@access.com", "password");
        $res = $client->getTokens($grant);
    }

    public function testGetTokensWithPassword()
    {
        $oauth2Config = new OAuth2\Config("id", "secret");
        $client = new Client($oauth2Config);
        $tokens = OAuth2\Tokens::fromArray([
            'access_token' => '000|access',
            'expires_in' => 3600,
            'refresh_token' => '000|refresh',
            'scope' => 'read_thermostat write_thermostat',
        ]);
        $httpClient = new Fixtures\Client([
            Fixtures\Responses\OAuth2\Tokens::fromTokens($tokens)
        ]);
        $client->setHttpClient($httpClient);
        $grant = new OAuth2\Grants\Password("user@access.com", "password");
        $res = $client->getTokens($grant);
        $this->assertEquals($tokens, $res);
    }

    public function testGetTokensWithAuthorizationCode()
    {
        $oauth2Config = new OAuth2\Config("id", "secret");
        $client = new Client($oauth2Config);
        $tokens = OAuth2\Tokens::fromArray([
            'access_token' => '000|access',
            'expires_in' => 3600,
            'refresh_token' => '000|refresh',
            'scope' => 'read_thermostat write_thermostat',
        ]);
        $httpClient = new Fixtures\Client([
            Fixtures\Responses\OAuth2\Tokens::fromTokens($tokens)
        ]);
        $client->setHttpClient($httpClient);
        $grant = new OAuth2\Grants\AuthorizationCode("000");
        $res = $client->getTokens($grant);
        $this->assertEquals($tokens, $res);
    }

    /**
     * @expectedException \Netatmo\Exceptions\Error
     * @expectedExceptionMessage invalid json
     */
    public function testThrowExceptionIfResponseHasNoBody()
    {
        $oauth2Config = new OAuth2\Config("id", "secret");
        $client = new Client($oauth2Config);
        $httpClient = new Fixtures\Client([
            new Fixtures\Responses\Json(400, "")
        ]);
        $client->setHttpClient($httpClient);
        $client->setAccessToken(new OAuth2\Token("000|access"));
        $request = Requests\WeatherStations::getDevice("70:ee:50:2c:70:ca");
        $client->send($request);
    }

    /**
     * @expectedException \Netatmo\Exceptions\ApiError
     * @expectedExceptionCode \Netatmo\ErrorCode::INVALID_ARG
     * @expectedExceptionMessage invalid argument
     */
    public function testThrowExceptionIfRequestFails()
    {
        $oauth2Config = new OAuth2\Config("id", "secret");
        $client = new Client($oauth2Config);
        $httpClient = new Fixtures\Client([
            new Fixtures\Responses\Json(
                400,
                [
                    "body" => [
                        "error" => [
                            "code" => ErrorCode::INVALID_ARG,
                            "message" => "invalid argument"
                        ]
                    ],
                    "time_server" => 121212
                ]
            )
        ]);
        $client->setHttpClient($httpClient);
        $client->setAccessToken(new OAuth2\Token("000|access"));
        $request = Requests\WeatherStations::getDevice("70:ee:50:2c:70:ca");
        $client->send($request);
    }

    public function testRetryIfAccessTokenIsExpired()
    {
        $oauth2Config = new OAuth2\Config("id", "secret");
        $client = new Client($oauth2Config);
        $tokens = OAuth2\Tokens::fromArray([
            'access_token' => '111|access',
            'expires_in' => 3600,
            'refresh_token' => '111|refresh',
            'scope' => 'read_thermostat write_thermostat',
        ]);
        $httpClient = new Fixtures\Client([
            new Fixtures\Responses\Json(
                400,
                [
                    "body" => [
                        "error" => [
                            "code" => ErrorCode::ACCESS_TOKEN_EXPIRED,
                        ]
                    ],
                    "time_server" => 121212
                ]
            ),
            Fixtures\Responses\OAuth2\Tokens::fromTokens($tokens),
            new Fixtures\Responses\Json(
                200,
                [
                    "body" => [],
                    "time_server" => 121213
                ]
            ),
        ]);
        $client->setHttpClient($httpClient);
        $client->setAccessToken(new OAuth2\Token("000|access"));
        $client->setRefreshToken(new OAuth2\Token("000|refresh"));
        $request = Requests\WeatherStations::getDevice("70:ee:50:2c:70:ca");
        $client->send($request);
        $this->assertEquals(
            (string) $client->getAccessToken(),
            "111|access"
        );
    }

    /**
     * @expectedException \Netatmo\Exceptions\OAuth2Error
     * @expectedExceptionCode 400
     */
    public function testRetryIfAccessTokenIsExpiredAndFailToGetNewAccessToken()
    {
        $oauth2Config = new OAuth2\Config("id", "secret");
        $client = new Client($oauth2Config);
        $tokens = OAuth2\Tokens::fromArray([
            'access_token' => '111|access',
            'expires_in' => 3600,
            'refresh_token' => '111|refresh',
            'scope' => 'read_thermostat write_thermostat',
        ]);
        $httpClient = new Fixtures\Client([
            new Fixtures\Responses\Json(
                400,
                [
                    "body" => [
                        "error" => [
                            "code" => ErrorCode::ACCESS_TOKEN_EXPIRED,
                        ]
                    ],
                    "time_server" => 121212
                ]
            ),
            new Fixtures\Responses\Json(
                400,
                [
                    "error" => "invalid_client"
                ]
            )
        ]);
        $client->setHttpClient($httpClient);
        $client->setAccessToken(new OAuth2\Token("000|access"));
        $client->setRefreshToken(new OAuth2\Token("000|refresh"));
        $request = Requests\WeatherStations::getDevice("70:ee:50:2c:70:ca");
        $client->send($request);
    }
}
