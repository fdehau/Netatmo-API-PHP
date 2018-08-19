<?php

namespace Netatmo\Sdk\Serialization\Models\Weather;

use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Serialization;
use Netatmo\Sdk\Models;

class WindMeasuresDeserializer extends MeasuresDeserializer
{
    const WIND_STRENGTH = "WindStrength";
    const WIND_ANGLE = "WindAngle";
    const GUST_STRENGTH = "GustStrength";
    const GUST_ANGLE = "GustAngle";

    public function __construct()
    {
        parent::__construct(Models\Weather\WindMeasures::class);
    }

    public function fromArray(array $array)
    {
        $measures = parent::fromArray($array);

        if (isset($array[self::WIND_STRENGTH])) {
            $measures->setWindStrength($array[self::WIND_STRENGTH]);
        }
        if (isset($array[self::WIND_ANGLE])) {
            $measures->setWindAngle($array[self::WIND_ANGLE]);
        }
        if (isset($array[self::GUST_STRENGTH])) {
            $measures->setGustStrength($array[self::GUST_STRENGTH]);
        }
        if (isset($array[self::GUST_ANGLE])) {
            $measures->setGustAngle($array[self::GUST_ANGLE]);
        }

        return $measures;
    }
}
