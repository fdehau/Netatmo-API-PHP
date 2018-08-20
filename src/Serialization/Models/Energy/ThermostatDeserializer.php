<?php

namespace Netatmo\Sdk\Serialization\Models\Energy;

use Netatmo\Sdk\Serialization;
use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Models;

class ThermostatDeserializer extends Serialization\Models\ModuleDeserializer
{
    public function __construct()
    {
        parent::__construct(Models\Energy\Thermostat::class);
    }

    public function fromArray(array $array)
    {
        $thermostat = parent::fromArray($array);

        return $thermostat;
    }
}
