<?php

namespace Netatmo\Requests;

use Netatmo\Api;
use Netatmo\Http;
use Netatmo\Exceptions;

/**
 * ```php
 * $request = WeatherStations::getDevice($deviceId)
 *      ->skipFavorites();
 * ```php
 */

class WeatherStations implements Request
{
    public function __construct($deviceId)
    {
        $this->deviceId = $deviceId;
        $this->includeFavorites = true;
    }

    public static function getDevice($deviceId)
    {
        return new self($deviceId);
    }

    public function skipFavorites()
    {
        $this->includeFavorites = false;
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

    public function withAuthorization()
    {
        return true;
    }

    public function getResponseClass()
    {
        return null;
    }
}
