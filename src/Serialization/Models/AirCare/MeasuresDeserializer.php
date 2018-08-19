<?php

namespace Netatmo\Sdk\Serialization\Models\AirCare;

use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Serialization;
use Netatmo\Sdk\Models;

class MeasuresDeserializer implements Serialization\ArrayDeserializer
{
    const TIMESTAMP = "time_utc";
    const TEMPERATURE = "Temperature";
    const HUMIDITY = "Humidity";
    const MAX_TEMPERATURE = "max_temp";
    const MAX_TEMPERATURE_TIMESTAMP = "date_max_temp";
    const MIN_TEMPERATURE = "min_temp";
    const MIN_TEMPERATURE_TIMESTAMP = "date_min_temp";
    const CO2 = "CO2";
    const NOISE = "Noise";

    public function fromArray(array $array)
    {
        if (!isset($array[self::TIMESTAMP])) {
            throw new Exceptions\Error("Missing timestamp");
        }
        $measures = new Models\AirCare\Measures($array[self::TIMESTAMP]);

        if (isset($array[self::TEMPERATURE])) {
            $measures->setTemperature($array[self::TEMPERATURE]);
        }
        if (isset($array[self::HUMIDITY])) {
            $measures->setHumidity($array[self::HUMIDITY]);
        }
        if (isset($array[self::MAX_TEMPERATURE])) {
            $temperature = new Models\AirCare\TemperatureExtremum($array[self::MAX_TEMPERATURE]);
            if (isset($array[self::MAX_TEMPERATURE_TIMESTAMP])) {
                $temperature->setTimestamp($array[self::MAX_TEMPERATURE_TIMESTAMP]);
            }
            $measures->setMaxTemperature($temperature);
        }
        if (isset($array[self::MIN_TEMPERATURE])) {
            $temperature = new Models\AirCare\TemperatureExtremum($array[self::MIN_TEMPERATURE]);
            if (isset($array[self::MIN_TEMPERATURE_TIMESTAMP])) {
                $temperature->setTimestamp($array[self::MIN_TEMPERATURE_TIMESTAMP]);
            }
            $measures->setMinTemperature($temperature);
        }
        if (isset($array[self::CO2])) {
            $measures->setCo2($array[self::CO2]);
        }
        if (isset($array[self::NOISE])) {
            $measures->setNoise($array[self::NOISE]);
        }

        return $measures;
    }
}
