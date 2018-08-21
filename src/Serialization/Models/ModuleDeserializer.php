<?php

namespace Netatmo\Sdk\Serialization\Models;

use Netatmo\Sdk\Serialization;
use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Models;

class ModuleDeserializer extends DeviceDeserializer
{
    const BRIDGE = "bridge";

    public function getDeviceClass()
    {
        return Models\Module::class;
    }

    public function fromArray(array $array)
    {
        $module = parent::fromArray($array);

        if (isset($array[self::BRIDGE])) {
            $module->setBridge($array[self::BRIDGE]);
        }

        return $module;
    }
}
