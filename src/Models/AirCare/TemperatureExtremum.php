<?php

namespace Netatmo\Sdk\Models\AirCare;

class TemperatureExtremum
{
    protected $value;
    protected $timestamp;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function setTimestamp($ts)
    {
        $this->timestamp = $ts;
    }
}
