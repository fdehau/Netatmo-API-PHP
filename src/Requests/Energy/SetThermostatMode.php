<?php

namespace Netatmo\Sdk\Requests\Energy;

use Netatmo\Sdk\Api;
use Netatmo\Sdk\Http;
use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Serialization;
use Netatmo\Sdk\Requests;

class SetThermostatMode implements Requests\Request
{
    protected $homeId;
    protected $mode;
    protected $end;

    public function __construct($homeId, $mode)
    {
        $this->homeId = $homeId;
        $this->mode = $mode;
    }

    public function setEnd($end)
    {
        $this->end = $end;
    }

    public function getPath()
    {
        return "api/setthermmode";
    }

    public function getMethod()
    {
        return Http\Method::POST;
    }

    public function getParams()
    {
        $params = [
            "home_id" => $this->homeId,
            "mode" => $this->mode,
        ];
        if ($this->end !== null) {
            $params["endtime"] = $this->end;
        }
        return $params;
    }

    public function getResponseDeserializer()
    {
        return new Serialization\Responses\EmptyDeserializer();
    }

    public function withAuthorization()
    {
        return true;
    }
}
