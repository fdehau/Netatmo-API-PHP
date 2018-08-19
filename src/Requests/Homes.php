<?php

namespace Netatmo\Sdk\Requests;

use Netatmo\Sdk\Http;
use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Serialization;

/**
 * ```php
 *  $request = Homes::getHome($homeId)
 *      ->withGatewayTypes(['NAPlug']);
 * ```
 */
class Homes implements Request
{
    protected $homeId;

    public static function getHome($homeId)
    {
        $request = new self();
        $request->setHomeId($homeId);
        return $request;
    }

    public function setHomeId($homeId)
    {
        $this->homeId = $homeId;
        return $this;
    }

    public function withGatewayTypes(array $types)
    {
        $this->gatewayTypes = $types;
        return $this;
    }

    public function getPath()
    {
        return "api/homesdata";
    }

    public function getMethod()
    {
        return Http\Method::GET;
    }

    public function getParams()
    {
        $params = [];

        if ($this->homeId !== null) {
            $params["home_id"] = $this->homeId;
        }
        if (!empty($this->gatewayTypes)) {
            $params["gateway_types"] = $this->gatewayTypes;
        }

        return $params;
    }

    public function getResponseDeserializer()
    {
        return new Serialization\Responses\HomesDeserializer();
    }

    public function withAuthorization()
    {
        return true;
    }
}
