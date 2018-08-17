<?php

namespace Netatmo\Sdk\OAuth2;

class Tokens
{
    const ACCESS_TOKEN = "access_token";
    const EXPIRES_IN = "expires_in";
    const REFRESH_TOKEN = "refresh_token";
    const SCOPES = "scope";
    const RESTRICTED_ACCESS_TOKEN = "restricted_access_token";
    const RESTRICTED_REFRESH_TOKEN = "restricted_refresh_token";

    protected $accessToken;
    protected $refreshToken;
    protected $scopes = [];
    protected $restrictedAccessToken;
    protected $restrictedRefreshToken;

    public function getAccessToken()
    {
        return $this->accessToken;
    }

    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    public function getRestrictedAccessToken()
    {
        return $this->restrictedAccessToken;
    }

    public function getRestrictedRefreshToken()
    {
        return $this->restrictedRefreshToken;
    }

    public function getScopes()
    {
        return $this->scopes;
    }

    public function setAccessToken(Token $token)
    {
        $this->accessToken = $token;
    }

    public function setRefreshToken(Token $token)
    {
        $this->refreshToken = $token;
    }

    public function setRestrictedAccessToken(Token $token)
    {
        $this->restrictedAccessToken = $token;
    }

    public function setRestrictedRefreshToken(Token $token)
    {
        $this->restrictedRefreshToken = $token;
    }

    public function setScopes(array $scopes)
    {
        $this->scopes = $scopes;
    }

    public static function fromArray(array $array)
    {
        $tokens = new self();
        if (isset($array[self::ACCESS_TOKEN])) {
            $value = $array[self::ACCESS_TOKEN];
            $expiration = null;
            if (isset($array[self::EXPIRES_IN])) {
                $expiration = time() + $array[self::EXPIRES_IN];
            }
            $token = new Token($value, $expiration);
            $tokens->setAccessToken($token);
        }
        if (isset($array[self::REFRESH_TOKEN])) {
            $token = new Token($array[self::REFRESH_TOKEN]);
            $tokens->setRefreshToken($token);
        }
        if (isset($array[self::SCOPES]) && is_string(self::SCOPES)) {
            $scopes = explode(" ", $array[self::SCOPES]);
            $tokens->setScopes($scopes);
        }
        return $tokens;
    }
}
