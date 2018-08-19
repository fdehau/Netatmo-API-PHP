<?php

namespace Netatmo\Sdk\Serialization\Models;

use Netatmo\Sdk\Responses;
use Netatmo\Sdk\Serialization;
use Netatmo\Sdk\Models;

class AdministrativeDeserializer implements Serialization\ArrayDeserializer
{
    const LANG = "lang";
    const LOCALE = "reg_locale";
    const COUNTRY = "country";
    const UNIT = "unit";
    const WIND_UNIT = "windunit";
    const PRESSURE_UNIT = "pressureunit";
    const FEEL_LIKE_ALGO = "feel_like_algo";

    public function fromArray(array $array)
    {
        $administrative = new Models\Administrative();

        if (isset($array[self::LANG])) {
            $administrative->setLang($array[self::LANG]);
        }
        if (isset($array[self::LOCALE])) {
            $administrative->setLocale($array[self::LOCALE]);
        }
        if (isset($array[self::COUNTRY])) {
            $administrative->setCountry($array[self::COUNTRY]);
        }
        if (isset($array[self::UNIT])) {
            $administrative->setUnit($array[self::UNIT]);
        }
        if (isset($array[self::WIND_UNIT])) {
            $administrative->setWindUnit($array[self::WIND_UNIT]);
        }
        if (isset($array[self::PRESSURE_UNIT])) {
            $administrative->setPressureUnit($array[self::PRESSURE_UNIT]);
        }
        if (isset($array[self::FEEL_LIKE_ALGO])) {
            $administrative->setFeelLikeAlgo($array[self::FEEL_LIKE_ALGO]);
        }

        return $administrative;
    }
}