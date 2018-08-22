<?php

namespace Netatmo\Sdk\Models\Energy;

class ThermostatMode
{
    protected $mode;
    protected $end;

    public function __construct($mode)
    {
        $this->mode = $mode;
    }

    public function getMode()
    {
        return $this->mode;
    }

    public function getEnd()
    {
        return $this->end;
    }

    public function setEnd($end)
    {
        $this->end = $end;
    }
}
