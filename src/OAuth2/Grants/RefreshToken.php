<?php

namespace Netatmo\Sdk\OAuth2\Grants;

use Netatmo\Sdk\OAuth2\Token;

class RefreshToken implements Grant
{
    /**
     * Token
     *
     * @var \Netatmo\OAuth2\Token
     */
    private $token;

    public function __construct(Token $token)
    {
        $this->token = $token;
    }

    public function getType()
    {
        return "refresh_token";
    }

    public function getParams()
    {
        return [
            "refresh_token" => $this->token,
        ];
    }
}
