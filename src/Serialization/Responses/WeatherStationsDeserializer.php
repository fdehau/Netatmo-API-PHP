<?php

namespace Netatmo\Sdk\Serialization\Responses;

use Netatmo\Sdk\Responses;
use Netatmo\Sdk\Serialization;

class WeatherStationsDeserializer implements Serialization\ArrayDeserializer
{
    const USER = "user";
    const DEVICES = "devices";

    public function fromArray(array $array)
    {
        $res = new Responses\WeatherStations();
        if (isset($array[self::USER])) {
            $de = new Serialization\Models\UserDeserializer();
            $user = $de->fromArray($array[self::USER]);
            $res->setUser($user);
        }
        if (isset($array[self::DEVICES])) {
            $de = new Serialization\Models\WeatherStationDeserializer();
            foreach ($array[self::DEVICES] as $device) {
                $weatherStation = $de->fromArray($device);
                $res->addStation($weatherStation);
            }
        }
        return $res;
    }
}
