<?php

namespace Netatmo\Sdk\OAuth2\Grants;

class AuthorizationCode implements Grant
{
    /**
     * Code
     *
     * @var string
     */
    private $code = null;

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function getType()
    {
        return "code";
    }

    public function getParams()
    {
        return [
            "code" => $this->code,
        ];
    }
}
