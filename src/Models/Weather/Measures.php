<?php

namespace Netatmo\Sdk\Models\Weather;

class Measures
{
    protected $timestamp;

    public function __construct($ts)
    {
        $this->timestamp = $ts;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }
}
