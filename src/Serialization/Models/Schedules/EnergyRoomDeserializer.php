<?php

namespace Netatmo\Sdk\Serialization\Models\Schedules;

use Netatmo\Sdk\Serialization;
use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Models;

class EnergyRoomDeserializer extends RoomDeserializer
{
    const TEMPERATURE = "therm_setpoint_temperature";

    public function getRoomClass()
    {
        return Models\Schedules\EnergyRoom::class;
    }

    public function fromArray(array $array)
    {
        $room = parent::fromArray($array);

        if (isset($array[self::TEMPERATURE])) {
            $room->setTemperature($array[self::TEMPERATURE]);
        }

        return $room;
    }
}
