<?php

namespace Netatmo\Sdk\Models\Weather;

class Pressure
{
    protected $value;
    protected $absoluteValue;
    protected $trend;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getAbsoluteValue()
    {
        return $this->absoluteValue;
    }

    public function getTrend()
    {
        return $this->trend;
    }

    public function setAbsoluteValue($value)
    {
        $this->absoluteValue = $value;
    }

    public function setTrend($trend)
    {
        $this->trend = $trend;
    }
}
