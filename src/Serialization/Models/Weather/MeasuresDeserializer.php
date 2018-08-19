<?php

namespace Netatmo\Sdk\Serialization\Models\Weather;

use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Serialization;
use Netatmo\Sdk\Models;

class MeasuresDeserializer implements Serialization\ArrayDeserializer
{
    public function __construct($class = Models\Weather\Measures::class)
    {
        $this->class = $class;
    }

    const TIMESTAMP = "time_utc";

    public function fromArray(array $array)
    {
        if (!isset($array[self::TIMESTAMP])) {
            throw new Exceptions\Error("Missing timestamp");
        }
        $measures = new $this->class($array[self::TIMESTAMP]);
        return $measures;
    }
}
