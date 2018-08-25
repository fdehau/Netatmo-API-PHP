<?php

namespace Netatmo\Sdk\Serialization\Models\Schedules;

use Netatmo\Sdk\Serialization;
use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Models;

class RoomSerializer extends Serialization\ArraySerializer
{
    const ID = "id";

    public function canSerialize($object)
    {
        return $object instanceof Models\Schedules\Room;
    }

    public function __toArray($room)
    {
        return [
            self::ID => $room->getId()
        ];
    }
}
