<?php

namespace Netatmo\Sdk\Serialization\Models;

use Netatmo\Sdk\Serialization;
use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Models;

abstract class DeviceDeserializer implements Serialization\ArrayDeserializer
{
    const ID = "id";
    const NAME = "name";
    const ROOM = "room_id";
    const SETUP_DATE = "setup_date";

    abstract public function getDeviceClass();

    public function fromArray(array $array)
    {
        if (!isset($array[self::ID])) {
            throw new Exceptions\Error("Missing id");
        }
        $class = $this->getDeviceClass();
        $device = new $class($array[self::ID]);

        if (isset($array[self::NAME])) {
            $device->setName($array[self::NAME]);
        }

        if (isset($array[self::SETUP_DATE])) {
            $installation = new Models\Installation($array[self::SETUP_DATE]);
            $device->setInstallation($installation);
        }

        if (isset($array[self::ROOM])) {
            $device->setRoom($array[self::ROOM]);
        }

        return $device;
    }
}
