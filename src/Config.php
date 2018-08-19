<?php

namespace Netatmo\Sdk;

class Config
{
    protected $uri;

    public function __construct()
    {
        $this->uri = Api::URI;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function setUri($uri)
    {
        $this->uri = $uri;
    }
}
