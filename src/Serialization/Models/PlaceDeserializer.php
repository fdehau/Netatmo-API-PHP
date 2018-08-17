<?php

namespace Netatmo\Sdk\Serialization\Models;

use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Serialization;
use Netatmo\Sdk\Models;

class PlaceDeserializer implements Serialization\ArrayDeserializer
{
    const ALTITUDE = "altitude";
    const CITY = "city";
    const COUNTRY = "country";
    const TIMEZONE = "timezone";
    const LOCATION = "location";

    public function fromArray(array $array)
    {
        $place = new Models\Place();
        if (isset($array[self::ALTITUDE])) {
            $place->setAltitude($array[self::ALTITUDE]);
        }
        if (isset($array[self::CITY])) {
            $place->setCity($array[self::CITY]);
        }
        if (isset($array[self::COUNTRY])) {
            $place->setCountry($array[self::COUNTRY]);
        }
        if (isset($array[self::TIMEZONE])) {
            $place->setTimezone($array[self::TIMEZONE]);
        }
        if (isset($array[self::LOCATION])) {
            $place->setLongitude($array[self::LOCATION][0]);
            $place->setLatitude($array[self::LOCATION][1]);
        }
        return $place;
    }
}
