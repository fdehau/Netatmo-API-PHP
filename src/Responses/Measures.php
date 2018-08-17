<?php

namespace Netatmo\Responses;

class Measures extends Response
{
    protected $measures = [];

    public function pushMeasure($type, $ts, $value)
    {
        if (!isset($this->measures[$type]))
        {
            $this->measures[$type] = [];
        }
        $this->measures[$type][$ts] = $value;
    }

    public function get($type)
    {
        return isset($this->measures[$type])
            ? $this->measures[$type]
            : [];
    }
}
