<?php

namespace Netatmo\Sdk\Models;

class Firmware
{
    protected $version;
    protected $lastUpdate;

    public function __construct($version)
    {
        $this->version = $version;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }

    public function setLastUpdate($ts)
    {
        $this->lastUpdate = $ts;
    }
}
