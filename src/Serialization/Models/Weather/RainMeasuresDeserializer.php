<?php

namespace Netatmo\Sdk\Serialization\Models\Weather;

use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Serialization;
use Netatmo\Sdk\Models;

class RainMeasuresDeserializer extends MeasuresDeserializer
{
    const LAST_HOUR_RAIN = "sum_rain_1";
    const LAST_DAY_RAIN = "sum_rain_24";

    public function __construct()
    {
        parent::__construct(Models\Weather\RainMeasures::class);
    }

    public function fromArray(array $array)
    {
        $measures = parent::fromArray($array);

        if (isset($array[self::LAST_HOUR_RAIN])) {
            $measures->setLastHourRain($array[self::LAST_HOUR_RAIN]);
        }
        if (isset($array[self::LAST_DAY_RAIN])) {
            $measures->setLastDayRain($array[self::LAST_DAY_RAIN]);
        }

        return $measures;
    }
}
