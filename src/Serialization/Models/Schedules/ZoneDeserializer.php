<?php

namespace Netatmo\Sdk\Serialization\Models\Schedules;

use Netatmo\Sdk\Serialization;
use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Models;

class ZoneDeserializer implements Serialization\ArrayDeserializer
{
    const ID = "id";
    const TYPE = "type";
    const NAME = "name";
    const ROOMS = "rooms";

    public function __construct($roomDeserializer)
    {
        $this->roomDeserializer = $roomDeserializer;
    }

    public function fromArray(array $array)
    {
        if (!isset($array[self::ID])) {
            throw new Exceptions\Error("Missing id");
        }
        if (!isset($array[self::TYPE])) {
            throw new Exceptions\Error("Missing type");
        }
        $zone = new Models\Schedules\Zone(
            $array[self::ID],
            $array[self::TYPE]
        );
        if (isset($array[self::NAME])) {
            $zone->setName($array[self::NAME]);
        }
        if (isset($array[self::ROOMS]) && is_array($array[self::ROOMS])) {
            foreach ($array[self::ROOMS] as $room) {
                $room = $this->roomDeserializer->fromArray($room);
                $zone->addRoom($room);
            }
        }
        return $zone;
    }
}
