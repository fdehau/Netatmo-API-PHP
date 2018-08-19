<?php

namespace Netatmo\Sdk\Models\Weather;

use Netatmo\Sdk\Models;

class OutdoorMeasures extends Measures
{
    protected $temperature;
    protected $humidity;
    protected $maxTemperature;
    protected $minTemperature;

    public function getTemperature()
    {
        return $this->temperature;
    }

    public function getHumidity()
    {
        return $this->humidity;
    }

    public function getMaxTemperature()
    {
        return $this->maxTemperature;
    }

    public function getMinTemperature()
    {
        return $this->minTemperature;
    }

    public function setTemperature($temperature)
    {
        $this->temperature = $temperature;
    }

    public function setHumidity($humidity)
    {
        $this->humidity = $humidity;
    }

    public function setMaxTemperature(TemperatureExtremum $maxTemperature)
    {
        $this->maxTemperature = $maxTemperature;
    }

    public function setMinTemperature(TemperatureExtremum $minTemperature)
    {
        $this->minTemperature = $minTemperature;
    }
}
