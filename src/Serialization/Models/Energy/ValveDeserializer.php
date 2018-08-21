<?php

namespace Netatmo\Sdk\Serialization\Models\Energy;

use Netatmo\Sdk\Serialization;
use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Models;

class ValveDeserializer extends Serialization\Models\ModuleDeserializer
{
    public function getDeviceClass()
    {
        return Models\Energy\Valve::class;
    }

    public function fromArray(array $array)
    {
        $valve = parent::fromArray($array);

        return $valve;
    }
}
