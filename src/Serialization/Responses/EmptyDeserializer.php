<?php

namespace Netatmo\Sdk\Serialization\Responses;

use Netatmo\Sdk\Responses;
use Netatmo\Sdk\Serialization;

class EmptyDeserializer implements Serialization\ArrayDeserializer
{
    public function fromArray(array $array)
    {
        return null;
    }
}
