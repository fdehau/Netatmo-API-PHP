<?php

namespace Netatmo\Sdk\Tests;

use Netatmo\Sdk\Client;
use Netatmo\Sdk\Config;
use Netatmo\Sdk\Http;
use Netatmo\Sdk\OAuth2;
use Netatmo\Sdk\ErrorCode;
use Netatmo\Sdk\Requests;
use Netatmo\Sdk\Tests\Fixtures;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    /**
     * @expectedException \Netatmo\Sdk\Exceptions\Error
     */
    public function testGetTokensFailWithNoBody()
    {
        $config = Config::fromArray([
            "oauth2" => [
                "client_id" => "id",
                "client_secret" => "secret"
            ]
        ]);
        $client = new Client($config);
        $httpClient = new Fixtures\Http\Client([
            new Fixtures\Responses\NoBody(400)
        ]);
        $client->setHttpClient($httpClient);
        $grant = new OAuth2\Grants\Password("user@access.com", "password");
        $res = $client->getTokens($grant);
    }

    /**
     * @expectedException \Netatmo\Sdk\Exceptions\Error
     */
    public function testGetTokensFailWithInvalidJson()
    {
        $config = Config::fromArray([
            "oauth2" => [
                "client_id" => "id",
                "client_secret" => "secret"
            ]
        ]);
        $client = new Client($config);
        $httpClient = new Fixtures\Http\Client([
            new Fixtures\Responses\Json(400, "{")
        ]);
        $client->setHttpClient($httpClient);
        $grant = new OAuth2\Grants\Password("user@access.com", "password");
        $res = $client->getTokens($grant);
    }

    /**
     * @expectedException \Netatmo\Sdk\Exceptions\OAuth2Error
     */
    public function testGetTokensFailWithOAuth2Error()
    {
        $config = Config::fromArray([
            "oauth2" => [
                "client_id" => "id",
                "client_secret" => "secret"
            ]
        ]);
        $client = new Client($config);
        $httpClient = new Fixtures\Http\Client([
            new Fixtures\Responses\OAuth2\Error(400, "invalid_token")
        ]);
        $client->setHttpClient($httpClient);
        $grant = new OAuth2\Grants\Password("user@access.com", "password");
        $res = $client->getTokens($grant);
    }

    /**
     * @expectedException \Netatmo\Sdk\Exceptions\OAuth2Error
     * @expectedExceptionMessage Missing parameter or invalid grant_type
     */
    public function testGetTokensFailWithOAuth2ErrorAndDescription()
    {
        $config = Config::fromArray([
            "oauth2" => [
                "client_id" => "id",
                "client_secret" => "secret"
            ]
        ]);
        $client = new Client($config);
        $httpClient = new Fixtures\Http\Client([
            new Fixtures\Responses\OAuth2\Error(400, "invalid_request", "Missing parameter or invalid grant_type")
        ]);
        $client->setHttpClient($httpClient);
        $grant = new OAuth2\Grants\Password("user@access.com", "password");
        $res = $client->getTokens($grant);
    }

    public function testGetTokensWithPassword()
    {
        $config = Config::fromArray([
            "oauth2" => [
                "client_id" => "id",
                "client_secret" => "secret"
            ]
        ]);
        $client = new Client($config);
        $tokens = OAuth2\Tokens::fromArray([
            'access_token' => '000|access',
            'expires_in' => 3600,
            'refresh_token' => '000|refresh',
            'scope' => 'read_thermostat write_thermostat',
        ]);
        $httpClient = new Fixtures\Http\Client([
            Fixtures\Responses\OAuth2\Tokens::fromTokens($tokens)
        ]);
        $client->setHttpClient($httpClient);
        $grant = new OAuth2\Grants\Password("user@access.com", "password");
        $res = $client->getTokens($grant);
        $this->assertEquals($tokens, $res);
    }

    public function testGetTokensWithAuthorizationCode()
    {
        $config = Config::fromArray([
            "oauth2" => [
                "client_id" => "id",
                "client_secret" => "secret"
            ]
        ]);
        $client = new Client($config);
        $tokens = OAuth2\Tokens::fromArray([
            'access_token' => '000|access',
            'expires_in' => 3600,
            'refresh_token' => '000|refresh',
            'scope' => 'read_thermostat write_thermostat',
        ]);
        $httpClient = new Fixtures\Http\Client([
            Fixtures\Responses\OAuth2\Tokens::fromTokens($tokens)
        ]);
        $client->setHttpClient($httpClient);
        $grant = new OAuth2\Grants\AuthorizationCode("000");
        $res = $client->getTokens($grant);
        $this->assertEquals($tokens, $res);
    }

    public function testCanChangeTokens()
    {
        $config = Config::fromArray([
            "oauth2" => [
                "client_id" => "id",
                "client_secret" => "secret"
            ]
        ]);
        $client = new Client($config);
        $tokens = OAuth2\Tokens::fromArray([
            'access_token' => '000|access',
            'expires_in' => 3600,
            'refresh_token' => '000|refresh',
            'scope' => 'read_thermostat write_thermostat',
        ]);
        $client->setAccessToken($tokens->getAccessToken());
        $this->assertEquals('000|access', (string) $client->getAccessToken());
        $client->setRefreshToken($tokens->getRefreshToken());
        $this->assertEquals('000|refresh', (string) $client->getRefreshToken());
    }

    public function testCanSetHttpOptions()
    {
        $config = Config::fromArray([
            "oauth2" => [
                "client_id" => "id",
                "client_secret" => "secret"
            ]
        ]);
        $client = new Client($config);
        $options = new Http\Options();
        $options->setTimeout(1);
        $client->setHttpOptions($options);
    }

    /**
     * @expectedException \Netatmo\Sdk\Exceptions\Error
     * @expectedExceptionMessage attempting to send a request without an access token
     */
    public function testThrowExceptionIfRequestNeedsAuthorization()
    {
        $config = Config::fromArray([
            "oauth2" => [
                "client_id" => "id",
                "client_secret" => "secret"
            ]
        ]);
        $client = new Client($config);
        $request = Requests\Weather\Stations::getDevice("70:ee:50:2c:70:ca");
        $client->send($request);
    }

    /**
     * @expectedException \Netatmo\Sdk\Exceptions\Error
     * @expectedExceptionMessage invalid json
     */
    public function testThrowExceptionIfResponseHasNoBody()
    {
        $config = Config::fromArray([
            "oauth2" => [
                "client_id" => "id",
                "client_secret" => "secret"
            ]
        ]);
        $client = new Client($config);
        $httpClient = new Fixtures\Http\Client([
            new Fixtures\Responses\Json(400, "")
        ]);
        $client->setHttpClient($httpClient);
        $client->setAccessToken(new OAuth2\Token("000|access"));
        $request = Requests\Weather\Stations::getDevice("70:ee:50:2c:70:ca");
        $client->send($request);
    }

    /**
     * @expectedException \Netatmo\Sdk\Exceptions\ApiError
     * @expectedExceptionCode \Netatmo\Sdk\ErrorCode::INVALID_ARG
     * @expectedExceptionMessage invalid argument
     */
    public function testThrowExceptionIfRequestFails()
    {
        $config = Config::fromArray([
            "oauth2" => [
                "client_id" => "id",
                "client_secret" => "secret"
            ]
        ]);
        $client = new Client($config);
        $httpClient = new Fixtures\Http\Client([
            new Fixtures\Responses\Json(
                400,
                [
                    "error" => [
                        "code" => ErrorCode::INVALID_ARG,
                        "message" => "invalid argument"
                    ]
                ]
            )
        ]);
        $client->setHttpClient($httpClient);
        $client->setAccessToken(new OAuth2\Token("000|access"));
        $request = Requests\Weather\Stations::getDevice("70:ee:50:2c:70:ca");
        $client->send($request);
    }

    public function testRetryIfAccessTokenIsExpired()
    {
        $config = Config::fromArray([
            "oauth2" => [
                "client_id" => "id",
                "client_secret" => "secret"
            ]
        ]);
        $client = new Client($config);
        $tokens = OAuth2\Tokens::fromArray([
            'access_token' => '111|access',
            'expires_in' => 3600,
            'refresh_token' => '111|refresh',
            'scope' => 'read_thermostat write_thermostat',
        ]);
        $httpClient = new Fixtures\Http\Client([
            Fixtures\Responses\OAuth2\Tokens::fromTokens($tokens),
            new Fixtures\Responses\Json(
                400,
                [
                    "error" => [
                        "code" => ErrorCode::ACCESS_TOKEN_EXPIRED,
                    ]
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
        $request = Requests\Weather\Stations::getDevice("70:ee:50:2c:70:ca");
        $client->send($request);
        $this->assertEquals(
            (string) $client->getAccessToken(),
            "111|access"
        );
    }

    /**
     * @expectedException \Netatmo\Sdk\Exceptions\OAuth2Error
     * @expectedExceptionCode 400
     */
    public function testRetryIfAccessTokenIsExpiredAndFailToGetNewAccessToken()
    {
        $config = Config::fromArray([
            "oauth2" => [
                "client_id" => "id",
                "client_secret" => "secret"
            ]
        ]);
        $client = new Client($config);
        $tokens = OAuth2\Tokens::fromArray([
            'access_token' => '111|access',
            'expires_in' => 3600,
            'refresh_token' => '111|refresh',
            'scope' => 'read_thermostat write_thermostat',
        ]);
        $httpClient = new Fixtures\Http\Client([
            new Fixtures\Responses\Json(
                400,
                [
                    "error" => [
                        "code" => ErrorCode::ACCESS_TOKEN_EXPIRED,
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
        $request = Requests\Weather\Stations::getDevice("70:ee:50:2c:70:ca");
        $client->send($request);
    }
}
