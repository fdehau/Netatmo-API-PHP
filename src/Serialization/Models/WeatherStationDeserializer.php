<?php

namespace Netatmo\Sdk\Serialization\Models;

use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Serialization;
use Netatmo\Sdk\Models;

class WeatherStationDeserializer implements Serialization\ArrayDeserializer
{
    const ID = "_id";
    const LAST_STATUS_TIMESTAMP = "last_status_store";
    const PLACE = "place";

    public function fromArray(array $array)
    {
        if (!isset($array[self::ID])) {
            throw new Exceptions\Error("Missing id inside device");
        }
        $weatherStation = new Models\WeatherStation($array[self::ID]);

        if (isset($array[self::LAST_STATUS_TIMESTAMP])) {
            $weatherStation->setLastStatusTimestamp($array[self::LAST_STATUS_TIMESTAMP]);
        }
        if (isset($array[self::PLACE])) {
            $de = new Serialization\Models\PlaceDeserializer();
            $place = $de->fromArray($array[self::PLACE]);
            $weatherStation->setPlace($place);
        }
        return $weatherStation;
    }
}
