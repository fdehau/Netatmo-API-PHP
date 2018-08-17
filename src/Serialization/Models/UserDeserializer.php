<?php

namespace Netatmo\Serialization\Models;

use Netatmo\Exceptions;
use Netatmo\Serialization;
use Netatmo\Models;

class UserDeserializer implements Serialization\ArrayDeserializer
{
    const EMAIL = "mail";
    const ADMINISTRATIVE = "administrative";

    public function fromArray(array $array)
    {
        if (!isset($array[self::EMAIL]))
        {
            throw new Exceptions\Error("Missing mail inside user");
        }
        $user = new Models\User($array[self::EMAIL]);

        if (isset($array[self::ADMINISTRATIVE]))
        {
            $de = new AdministrativeDeserializer();
            $administrative = $de->fromArray($array[self::ADMINISTRATIVE]);
            $user->setAdministrative($administrative);
        }

        return $user;
    }
}
