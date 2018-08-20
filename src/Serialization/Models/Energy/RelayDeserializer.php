<?php

namespace Netatmo\Sdk\Serialization\Models\Energy;

use Netatmo\Sdk\Serialization;
use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Models;

class RelayDeserializer extends Serialization\Models\GatewayDeserializer
{
    public function __construct()
    {
        parent::__construct(Models\Energy\Relay::class);
    }

    public function fromArray(array $array)
    {
        $gateway = parent::fromArray($array);

        return $gateway;
    }
}
