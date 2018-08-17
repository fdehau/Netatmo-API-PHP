<?php

namespace Netatmo\Sdk\Tests\Fixtures\Responses\OAuth2;

use Netatmo\Sdk\Tests\Fixtures\Responses;
use Netatmo\Sdk\OAuth2;

class Tokens extends Responses\Json
{
    public static function fromTokens(OAuth2\Tokens $tokens)
    {
        $body = [
            "access_token" => (string) $tokens->getAccessToken(),
            "expires_in" => $tokens->getAccessToken()->getExpiration() - time(),
            "refresh_token" => (string) $tokens->getRefreshToken(),
            "scope" => join(" ", $tokens->getScopes()),
        ];
        $restrictedAccessToken = $tokens->getRestrictedAccessToken();
        if ($restrictedAccessToken !== null) {
            $body["restricted_access_token"] = (string) $restrictedAccessToken;
        }
        $restrictedRefreshToken = $tokens->getRestrictedRefreshToken();
        if ($restrictedRefreshToken !== null) {
            $body['restricted_refresh_token'] = (string) $restrictedRefreshToken;
        }
        return new self(200, $body);
    }
}
