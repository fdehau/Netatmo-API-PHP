<?php

namespace Netatmo\Sdk\Models\Weather;

use Netatmo\Sdk\Models;

class StationMeasures extends Measures
{
    protected $timestamp;
    protected $temperature;
    protected $humidity;
    protected $co2;
    protected $pressure;
    protected $noise;

    public function __construct($ts)
    {
        $this->timestamp = $ts;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function getTemperature()
    {
        return $this->temperature;
    }

    public function getHumidity()
    {
        return $this->humidity;
    }

    public function getCo2()
    {
        return $this->co2;
    }

    public function getPressure()
    {
        return $this->pressure;
    }

    public function getNoise()
    {
        return $this->noise;
    }

    public function setTemperature($temperature)
    {
        $this->temperature = $temperature;
    }

    public function setHumidity($humidity)
    {
        $this->humidity = $humidity;
    }

    public function setCo2($co2)
    {
        $this->co2 = $co2;
    }

    public function setPressure(Pressure $pressure)
    {
        $this->pressure = $pressure;
    }

    public function setNoise($noise)
    {
        $this->noise = $noise;
    }
}
