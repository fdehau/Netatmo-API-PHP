<?php

namespace Netatmo\Sdk\Models\Energy;

class ThermostatSettings
{
    protected $setpointDefaultDuration;

    public function getSetpointDefaultDuration()
    {
        return $this->setpointDefaultDuration;
    }

    public function setSetpointDefaultDuration($duration)
    {
        $this->setpointDefaultDuration = $duration;
    }
}
