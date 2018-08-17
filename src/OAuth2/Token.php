<?php

namespace Netatmo\Sdk\OAuth2;

class Token
{
    public function __construct($value, $expiration = null)
    {
        $this->value = $value;
        $this->expiration = $expiration;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getExpiration()
    {
        return $this->expiration;
    }

    public function isExpired()
    {
        return $this->expiration === null || $this->expiration >= time();
    }

    public function __toString()
    {
        return (string) $this->value;
    }
}
