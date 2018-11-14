<?php

namespace Netatmo\Sdk\Serialization\Responses;

use Netatmo\Sdk\Responses;
use Netatmo\Sdk\Serialization;

class BaseDeserializer implements Serialization\ArrayDeserializer
{
    public function fromArray(array $array)
    {
        return new Responses\Response($array);
    }
}
