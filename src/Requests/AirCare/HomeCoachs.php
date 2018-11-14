<?php

namespace Netatmo\Sdk\Requests\AirCare;

use Netatmo\Sdk\Api;
use Netatmo\Sdk\Http;
use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Serialization;
use Netatmo\Sdk\Requests;

/**
 * ```php
 * $request = HomeCoachs::getDevice($deviceId)
 * ```php
 */

class HomeCoachs implements Requests\Request
{
    public function __construct($deviceId)
    {
        $this->deviceId = $deviceId;
    }

    public static function getDevice($deviceId)
    {
        return new self($deviceId);
    }

    public function getPath()
    {
        return "api/gethomecoachsdata";
    }

    public function getMethod()
    {
        return Http\Method::GET;
    }

    public function getParams()
    {
        return [
            "device_id" => $this->deviceId,
        ];
    }

    public function getResponseDeserializer()
    {
        return new Serialization\Responses\BaseDeserializer();
    }

    public function withAuthorization()
    {
        return true;
    }
}
