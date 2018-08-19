<?php

namespace Netatmo\Sdk\Serialization\Models\Weather;

use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Serialization;
use Netatmo\Sdk\Models;

class OutdoorMeasuresDeserializer extends MeasuresDeserializer
{
    const TEMPERATURE = "Temperature";
    const HUMIDITY = "Humidity";
    const MAX_TEMPERATURE = "max_temp";
    const MAX_TEMPERATURE_TIMESTAMP = "date_max_temp";
    const MIN_TEMPERATURE = "min_temp";
    const MIN_TEMPERATURE_TIMESTAMP = "date_min_temp";

    public function __construct()
    {
        parent::__construct(Models\Weather\OutdoorMeasures::class);
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
        if (isset($array[self::MAX_TEMPERATURE])) {
            $temperature = new Models\Weather\TemperatureExtremum($array[self::MAX_TEMPERATURE]);
            if (isset($array[self::MAX_TEMPERATURE_TIMESTAMP])) {
                $temperature->setTimestamp($array[self::MAX_TEMPERATURE_TIMESTAMP]);
            }
            $measures->setMaxTemperature($temperature);
        }
        if (isset($array[self::MIN_TEMPERATURE])) {
            $temperature = new Models\Weather\TemperatureExtremum($array[self::MIN_TEMPERATURE]);
            if (isset($array[self::MIN_TEMPERATURE_TIMESTAMP])) {
                $temperature->setTimestamp($array[self::MIN_TEMPERATURE_TIMESTAMP]);
            }
            $measures->setMinTemperature($temperature);
        }

        return $measures;
    }
}
