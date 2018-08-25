<?php

namespace Netatmo\Sdk\Serialization\Models\Schedules;

use Netatmo\Sdk\Serialization;
use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Models;

class ZoneSerializer extends Serialization\ArraySerializer
{
    const ID = "id";
    const TYPE = "type";
    const NAME = "name";
    const ROOMS = "rooms";

    protected $roomSerializer;

    public function __construct($roomSerializer)
    {
        $this->roomSerializer = $roomSerializer;
    }

    public function canSerialize($object)
    {
        return $object instanceof Models\Schedules\Zone;
    }

    public function __toArray($zone)
    {
        $array = [
            self::ID => $zone->getId(),
            self::TYPE => $zone->getType(),
        ];
        $name = $zone->getName();
        if ($name !== null) {
            $array[self::NAME] = $name;
        }

        $rooms = [];
        foreach ($zone->getRooms() as $room) {
            $rooms[] = $this->roomSerializer->toArray($room);
        }
        $array[self::ROOMS] = $rooms;

        return $array;
    }
}
