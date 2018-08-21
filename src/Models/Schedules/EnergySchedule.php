<?php

namespace Netatmo\Sdk\Models\Schedules;

class EnergySchedule extends Schedule
{
    protected $awayTemperature;
    protected $frostguardTemperature;

    public function getAwayTemperature()
    {
        return $this->awayTemperature;
    }

    public function getFrostguardTemperature()
    {
        return $this->frostguardTemperature;
    }

    public function setAwayTemperature($temperature)
    {
        $this->awayTemperature = $temperature;
    }

    public function setFrostguardTemperature($temperature)
    {
        $this->frostguardTemperature = $temperature;
    }
}
