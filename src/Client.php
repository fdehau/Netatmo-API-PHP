<?php

namespace Netatmo;

class Client
{
    const ACCESS_TOKEN_URI = "https://api.netatmo.com";

    /**
     * OAuth2 configuration
     *
     * @var Netatmo\OAuth2\Config
     */
    protected $oauth2Config = null;

    /**
     * @var Netatmo\Http\Client;
     */
    protected $httpClient = null;

    protected $httpOptions = null;

    protected $accessToken = null;

    protected $refreshToken = null;

    public function __construct(OAuth2\Config $oauth2Config)
    {
        $this->oauth2Config = $oauth2Config;
        $this->httpClient = new Http\GuzzleClient();
    }

    public function getHttpOptions()
    {
        return is_null($this->httpOptions)
            ? new Http\Options()
            : $this->httpOptions;
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }

    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    public function setHttpClient(Http\Client $client)
    {
        $this->httpClient = $client;
    }

    public function setHttpOptions(Http\Options $options)
    {
        $this->httpOptions = $options;
    }

    public function setAccessToken(OAuth2\Token $token)
    {
        $this->accessToken = $token;
    }

    public function setRefreshToken(OAuth2\Token $token)
    {
        $this->refreshToken = $token;
    }

    public function getTokens(OAuth2\Grants\Grant $grant)
    {
        $body = $this->oauth2Config->getParams($grant);
        $body = Http\Body::withFormParams($body);

        $uri = $this->oauth2Config->getTokenUri();

        $request = $this->httpClient->getRequest(Http\Method::POST, $uri);
        $request = $request->withHeader(
            "Content-Type",
            "application/x-www-form-urlencoded"
        );
        $request = $request->withBody($body);

        $response = $this->httpClient->send($request, $this->getHttpOptions());

        $status = $response->getStatusCode();
        $body = (string) $response->getBody();
        $body = json_decode($body, true);
        if ($body === null) {
            throw new Exceptions\Error(
                "invalid json or body is missing in oauth2/token response"
            );
        }
        if ($status === 200) {
            return OAuth2\Tokens::fromArray($body);
        } else {
            $msg = isset($body["error_description"])
                ? $body["error_description"]
                : "";
            $error = isset($body["error"])
                ? $body["error"]
                : "";
            $ex = new Exceptions\OAuth2Error($msg, $status);
            $ex->setError($error);
            throw $ex;
        }
    }

    public function send(Requests\Request $request)
    {
        try {
            return $this->transfer($request);
        } catch (Exceptions\ApiError $ex) {
            if ($ex->getCode() === ErrorCode::ACCESS_TOKEN_EXPIRED &&
                $this->refreshToken !== null) {
                $grant = new OAuth2\Grants\RefreshToken($this->refreshToken);
                $tokens = $this->getTokens($grant);
                $this->setAccessToken($tokens->getAccessToken());
                $this->setRefreshToken($tokens->getRefreshToken());
                return $this->transfer($request);
            }
            throw $ex;
        }
    }

    public function transfer(Requests\Request $request)
    {
        if ($request->withAuthorization() && $this->accessToken === null) {
            throw Exceptions\Error("attempting to send a request without an access token");
        }

        // Build path
        $path = ($request->getMethod() === Http\Method::GET)
            ? $request->getPath() . "?" . http_build_query($request->getParams(), null, "&")
            : $request->getPath();

        // Build HTTP request
        $httpRequest = $this->httpClient->getRequest(
            $request->getMethod(),
            $request->getPath()
        );

        // Set body it's a POST request
        if ($request->getMethod() === Http\Method::POST) {
            $body = Body::withJson($request->getParams());
            $httpRequest = $httpRequest->withBody($body);
            $httpRequest = $httpRequest->withHeader('Content-Type', 'application/json');
        }

        $response = $this->httpClient->send($httpRequest, $this->getHttpOptions());

        $status = $response->getStatusCode();
        $body = (string) $response->getBody();
        $body = json_decode($body, true);
        if ($body === null) {
            throw new Exceptions\Error(
                "invalid json or body is missing in API response"
            );
        }
        if ($status === 200) {
            $result = isset($body['body']) ? $body['body'] : [];
            $deserializer = $request->getResponseDeserializer();
            if ($deserializer === null) {
                return $body;
            } else {
                $response = call_user_func_array(
                    [$deserializer, "fromArray"],
                    [$result]
                );
                if (isset($body['time_server'])) {
                    $response->setTimestamp($body['time_server']);
                }
                return $response;
            }
        } else {
            $result = isset($body['body']) ? $body['body'] : [];
            $error = isset($result['error']) ? $result['error'] : [];
            $code = isset($error['code']) ? $error['code'] : null;
            $msg= isset($error['message']) ? $error['message'] : null;
            throw new Exceptions\ApiError($msg, $code);
        }
    }
}
