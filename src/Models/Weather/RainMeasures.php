<?php

namespace Netatmo\Sdk\Models\Weather;

use Netatmo\Sdk\Models;

class RainMeasures extends Measures
{
    protected $lastHourRain;
    protected $lastDayRain;

    public function getLastHourRain()
    {
        return $this->lastHourRain;
    }

    public function getLastDayRain()
    {
        return $this->lastDayRain;
    }

    public function setLastHourRain($lastHourRain)
    {
        $this->lastHourRain = $lastHourRain;
    }

    public function setLastDayRain($lastDayRain)
    {
        $this->lastDayRain = $lastDayRain;
    }
}
