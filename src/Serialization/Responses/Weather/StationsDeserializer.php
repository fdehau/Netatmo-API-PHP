<?php

namespace Netatmo\Sdk\Serialization\Responses\Weather;

use Netatmo\Sdk\Responses;
use Netatmo\Sdk\Serialization;

class StationsDeserializer implements Serialization\ArrayDeserializer
{
    const USER = "user";
    const DEVICES = "devices";

    public function fromArray(array $array)
    {
        $res = new Responses\Weather\Stations();
        if (isset($array[self::USER])) {
            $de = new Serialization\Models\UserDeserializer();
            $user = $de->fromArray($array[self::USER]);
            $res->setUser($user);
        }
        if (isset($array[self::DEVICES])) {
            $de = new Serialization\Models\Weather\StationDeserializer();
            foreach ($array[self::DEVICES] as $device) {
                $weatherStation = $de->fromArray($device);
                $res->addStation($weatherStation);
            }
        }
        return $res;
    }
}
