<?php

namespace Netatmo\Sdk\Serialization\Models\Schedules;

use Netatmo\Sdk\Serialization;
use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Models;

class EnergyRoomSerializer extends RoomSerializer
{
    const TEMPERATURE = "therm_setpoint_temperature";

    public function canSerialize($object)
    {
        return $object instanceof Models\Schedules\EnergyRoom;
    }

    public function __toArray($room)
    {
        $array = parent::__toArray($room);
        $temperature = $room->getTemperature();
        if ($temperature !== null) {
            $array[self::TEMPERATURE] = $temperature;
        }
        return $array;
    }
}
