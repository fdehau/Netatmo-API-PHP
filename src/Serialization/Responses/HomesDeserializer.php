<?php

namespace Netatmo\Sdk\Serialization\Responses;

use Netatmo\Sdk\Responses;
use Netatmo\Sdk\Serialization;

class HomesDeserializer implements Serialization\ArrayDeserializer
{
    const USER = "user";
    const HOMES = "homes";

    public function fromArray(array $array)
    {
        $res = new Responses\Homes();
        if (isset($array[self::USER])) {
            $de = new Serialization\Models\UserDeserializer();
            $user = $de->fromArray($array[self::USER]);
            $res->setUser($user);
        }
        if (isset($array[self::HOMES]) && is_array($array[self::HOMES])) {
            $de = new Serialization\Models\HomeDeserializer();
            foreach ($array[self::HOMES] as $home) {
                $home = $de->fromArray($home);
                $res->addHome($home);
            }
        }
        return $res;
    }
}
