<?php

namespace Netatmo\Sdk\OAuth2\Grants;

class Password implements Grant
{
    /**
     * Username
     *
     * @var string
     */
    private $username = null;

    /**
     * Password
     * @var string
     */
    private $password = null;

    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function getType()
    {
        return "password";
    }

    public function getParams()
    {
        return [
            "username" => $this->username,
            "password" => $this->password,
        ];
    }
}
