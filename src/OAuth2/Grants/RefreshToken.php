<?php

namespace Netatmo\OAuth2\Grants;

use Netatmo\OAuth2\Token;

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

    public function toArray()
    {
        return [
            "refresh_token" => $this->token,
        ];
    }
}
