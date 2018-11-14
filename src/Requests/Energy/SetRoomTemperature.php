<?php

namespace Netatmo\Sdk\Requests\Energy;

use Netatmo\Sdk\Api;
use Netatmo\Sdk\Http;
use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Serialization;
use Netatmo\Sdk\Requests;

class SetRoomTemperature implements Requests\Request
{
    protected $homeId;
    protected $roomId;
    protected $mode;
    protected $temperature;
    protected $end;

    public function __construct($homeId, $roomId, $mode)
    {
        $this->homeId = $homeId;
        $this->roomId = $roomId;
        $this->mode = $mode;
    }

    public static function withHomeMode($homeId, $roomId)
    {
        return new self($homeId, $roomId, "home");
    }

    public static function withTemperature($homeId, $roomId, $temperature)
    {
        $request = new self($homeId, $roomId, "manual");
        $request->setTemperature($temperature);
        return $request;
    }

    public function setTemperature($temperature)
    {
        $this->temperature = $temperature;
    }

    public function setEnd($end)
    {
        $this->end = $end;
    }

    public function getPath()
    {
        return "api/setroomthermpoint";
    }

    public function getMethod()
    {
        return Http\Method::POST;
    }

    public function getParams()
    {
        $params = [
            "home_id" => $this->homeId,
            "room_id" => $this->roomId,
            "mode" => $this->mode,
        ];
        if ($this->mode === "manual" &&
            $this->temperature !== null) {
            $params["temp"] = $this->temperature;
        }
        if ($this->end !== null) {
            $params["endtime"] = $this->end;
        }
        return $params;
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
