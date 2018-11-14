<?php

namespace Netatmo\Sdk\Requests\Weather;

use Netatmo\Sdk\Api;
use Netatmo\Sdk\Http;
use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Serialization;
use Netatmo\Sdk\Requests;

class Stations implements Requests\Request
{
    public function __construct($deviceId)
    {
        $this->deviceId = $deviceId;
        $this->includeFavorites = null;
    }

    public static function getDevice($deviceId)
    {
        return new self($deviceId);
    }

    public function includeFavorites($bool)
    {
        $this->includeFavorites = $bool;
        return $this;
    }

    public function getPath()
    {
        return "api/getstationsdata";
    }

    public function getMethod()
    {
        return Http\Method::GET;
    }

    public function getParams()
    {
        $params = [
            "device_id" => $this->deviceId
        ];

        if (!is_null($this->includeFavorites)) {
            $params["get_favorites"] = $this->includeFavorites;
        }

        return $params;
    }

    public function getResponseDeserializer()
    {
        return null;
    }

    public function withAuthorization()
    {
        return true;
    }
}
