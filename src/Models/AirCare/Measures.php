<?php

namespace Netatmo\Sdk\Models\AirCare;

class Measures
{
    protected $timestamp;
    protected $temperature;
    protected $humidity;
    protected $maxTemperature;
    protected $minTemperature;
    protected $co2;
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

    public function getMaxTemperature()
    {
        return $this->maxTemperature;
    }

    public function getMinTemperature()
    {
        return $this->minTemperature;
    }

    public function getCo2()
    {
        return $this->co2;
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

    public function setMaxTemperature(TemperatureExtremum $maxTemperature)
    {
        $this->maxTemperature = $maxTemperature;
    }

    public function setMinTemperature(TemperatureExtremum $minTemperature)
    {
        $this->minTemperature = $minTemperature;
    }

    public function setCo2($co2)
    {
        $this->co2 = $co2;
    }

    public function setNoise($noise)
    {
        $this->noise = $noise;
    }
}
