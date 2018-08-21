<?php

namespace Netatmo\Sdk\Serialization\Models\Schedules;

use Netatmo\Sdk\Serialization;
use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Models;

abstract class RoomDeserializer implements Serialization\ArrayDeserializer
{
    const ID = "id";

    abstract public function getRoomClass();

    public function fromArray(array $array)
    {
        if (!isset($array[self::ID])) {
            throw Exceptions\Error("Missing id");
        }
        $class = $this->getRoomClass();
        $room = new $class($array[self::ID]);
        return $room;
    }
}
