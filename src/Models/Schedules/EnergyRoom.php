<?php

namespace Netatmo\Sdk\Models\Schedules;

class EnergyRoom extends Room
{
    protected $temperature;

    public function getTemperature()
    {
        return $this->temperature;
    }

    public function setTemperature($temperature)
    {
        $this->temperature = $temperature;
    }
}
