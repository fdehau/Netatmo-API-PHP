<?php

namespace Netatmo\Sdk\Serialization\Responses\AirCare;

use Netatmo\Sdk\Responses;
use Netatmo\Sdk\Serialization;

class HomeCoachsDeserializer implements Serialization\ArrayDeserializer
{
    const USER = "user";
    const DEVICES = "devices";

    public function fromArray(array $array)
    {
        $res = new Responses\AirCare\HomeCoachs();
        if (isset($array[self::USER])) {
            $de = new Serialization\Models\UserDeserializer();
            $user = $de->fromArray($array[self::USER]);
            $res->setUser($user);
        }
        if (isset($array[self::DEVICES])) {
            $de = new Serialization\Models\AirCare\HomeCoachDeserializer();
            foreach ($array[self::DEVICES] as $device) {
                $homeCoach = $de->fromArray($device);
                $res->addHomeCoach($homeCoach);
            }
        }
        return $res;
    }
}
