<?php

namespace Netatmo\Sdk\Serialization\Models;

use Netatmo\Sdk\Serialization;
use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Models;

class HomeDeserializer implements Serialization\ArrayDeserializer
{
    const ID = "id";
    const NAME = "name";

    public function fromArray(array $array)
    {
        if (!isset($array[self::ID])) {
            throw new Exceptions\Error("Missing id");
        }
        $home = new Models\Home($array[self::ID]);

        if (isset($array[self::NAME])) {
            $home->setName($array[self::NAME]);
        }

        $de = new PlaceDeserializer(PlaceDeserializer::COORDINATES);
        $place = $de->fromArray($array);
        $home->setPlace($place);

        return $home;
    }
}
