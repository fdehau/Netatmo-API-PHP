<?php

namespace Netatmo\Sdk\Serialization\Models\Weather;

use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Serialization;
use Netatmo\Sdk\Models;

class StationMeasuresDeserializer extends MeasuresDeserializer
{
    const TEMPERATURE = "Temperature";
    const HUMIDITY = "Humidity";
    const CO2 = "CO2";
    const PRESSURE = "Pressure";
    const ABSOLUTE_PRESSURE = "AbsolutePressure";
    const PRESSURE_TREND = "pressure_trend";
    const NOISE = "Noise";

    public function __construct()
    {
        parent::__construct(Models\Weather\StationMeasures::class);
    }

    public function fromArray(array $array)
    {
        $measures = parent::fromArray($array);

        if (isset($array[self::TEMPERATURE])) {
            $measures->setTemperature($array[self::TEMPERATURE]);
        }
        if (isset($array[self::HUMIDITY])) {
            $measures->setHumidity($array[self::HUMIDITY]);
        }
        if (isset($array[self::CO2])) {
            $measures->setCo2($array[self::CO2]);
        }
        if (isset($array[self::PRESSURE])) {
            $pressure = new Models\Weather\Pressure($array[self::PRESSURE]);
            if (isset($array[self::ABSOLUTE_PRESSURE])) {
                $pressure->setAbsoluteValue($array[self::ABSOLUTE_PRESSURE]);
            }
            if (isset($array[self::PRESSURE_TREND])) {
                $pressure->setTrend($array[self::PRESSURE_TREND]);
            }
            $measures->setPressure($pressure);
        }
        if (isset($array[self::NOISE])) {
            $measures->setNoise($array[self::NOISE]);
        }

        return $measures;
    }
}
