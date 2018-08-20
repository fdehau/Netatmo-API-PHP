<?php

namespace Netatmo\Sdk\Serialization\Models;

use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Serialization;
use Netatmo\Sdk\Models;

class RoomDeserializer implements Serialization\ArrayDeserializer
{
    const ID = "id";
    const NAME = "name";
    const TYPE = "type";
    const MODULE_IDS = "modules_ids";

    public function fromArray(array $array)
    {
        if (!isset($array[self::ID])) {
            throw new Exceptions\Error("Missing id");
        }
        $room = new Models\Room($array[self::ID]);
        if (isset($array[self::NAME])) {
            $room->setName($array[self::NAME]);
        }
        if (isset($array[self::TYPE])) {
            $room->setType($array[self::TYPE]);
        }
        if (isset($array[self::MODULE_IDS]) &&
            is_array($array[self::MODULE_IDS])) {
            foreach ($array[self::MODULE_IDS] as $id) {
                $room->addModule($id);
            }
        }
        return $room;
    }
}
