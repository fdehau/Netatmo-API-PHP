<?php

namespace Netatmo\Sdk\Serialization\Models;

use Netatmo\Sdk\Serialization;
use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Models;

class GatewayDeserializer extends DeviceDeserializer
{
    const MODULES = "modules_bridged";

    public function __construct($class = Models\Gateway::class)
    {
        parent::__construct($class);
    }

    public function fromArray(array $array)
    {
        $gateway = parent::fromArray($array);

        if (isset($array[self::MODULES]) && is_array($array[self::MODULES])) {
            foreach ($array[self::MODULES] as $id) {
                $gateway->addModule($id);
            }
        }

        return $gateway;
    }
}
