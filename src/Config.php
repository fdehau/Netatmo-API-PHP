<?php

namespace Netatmo\Sdk;

class Config
{
    protected $oauth2;
    protected $uri;

    public function __construct(OAuth2\Config $oauth2)
    {
        $this->oauth2 = $oauth2;
        $this->uri = Api::URI;
    }

    public function getOAuth2()
    {
        return $this->oauth2;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    public static function fromArray(array $array)
    {
        if (!isset($array["oauth2"])) {
            throw new Exceptions\Error("Missing oauth2 config");
        }
        $oauth2 = OAuth2\Config::fromArray($array["oauth2"]);
        $config = new self($oauth2);
        if (isset($array["uri"])) {
            $config->setUri($uri);
        }
        return $config;
    }
}
