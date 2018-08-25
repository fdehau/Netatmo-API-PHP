<?php

namespace Netatmo\Sdk\Requests\Energy;

use Netatmo\Sdk\Http;
use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Serialization;
use Netatmo\Sdk\Requests;
use Netatmo\Sdk\Parameters;

class RoomMeasures implements Requests\Request
{
    public function __construct(
        Parameters\Room $room,
        Parameters\Measures $measures
    ) {
        $this->room = $room;
        $this->measures = $measures;
    }

    public function getPath()
    {
        return "api/getroommeasure";
    }

    public function getMethod()
    {
        return Http\Method::POST;
    }

    public function getParams()
    {
        $params = [
            "room_id" => $this->room->getId(),
            "home_id" => $this->room->getHomeId(),
            "scale" => $this->measures->getScale(),
            "type" => implode(",", $this->measures->getTypes()),
            "optimize" => $this->measures->isOptimized(),
            "real_time" => !$this->measures->shouldKeepOffset(),
        ];

        if ($this->measures->hasStart()) {
            $params["start"] = $this->measures->getStart();
        }
        if ($this->measures->hasEnd()) {
            $params["end"] = $this->measures->getEnd();
        }
        if ($this->measures->hasLimit()) {
            $params["limit"] = $this->measures->getLimit();
        }

        return $params;
    }

    public function withAuthorization()
    {
        return true;
    }

    public function getResponseDeserializer()
    {
        return new Serialization\Responses\MeasuresDeserializer(
            $this->measures->isOptimized(),
            $this->measures->getTypes()
        );
    }
}
