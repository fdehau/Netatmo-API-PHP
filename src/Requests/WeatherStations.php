<?php

namespace Netatmo\Requests;

use Netatmo\Api;
use Netatmo\Http;
use Netatmo\Exceptions;
use Netatmo\Serialization;

/**
 * ```php
 * $request = WeatherStations::getDevice($deviceId)
 *      ->includeFavorites();
 * ```php
 */

class WeatherStations implements Request
{
    public function __construct($deviceId)
    {
        $this->deviceId = $deviceId;
        $this->includeFavorites = false;
    }

    public static function getDevice($deviceId)
    {
        return new self($deviceId);
    }

    public function includeFavorites()
    {
        $this->includeFavorites = true;
        return $this;
    }

    public function getPath()
    {
        return Api::URI . "/getstationsdata";
    }

    public function getMethod()
    {
        return Http\Method::GET;
    }

    public function getParams()
    {
        return [
            "device_id" => $this->deviceId,
            "get_favorites" => $this->includeFavorites
        ];
    }

    public function getResponseDeserializer()
    {
        return new Serialization\Responses\WeatherStationsDeserializer();
    }

    public function withAuthorization()
    {
        return true;
    }

}
