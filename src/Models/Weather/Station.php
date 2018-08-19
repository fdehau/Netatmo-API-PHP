<?php

namespace Netatmo\Sdk\Models\Weather;

use Netatmo\Sdk\Models;
use Netatmo\Sdk\Exceptions;

class Station extends Models\Device
{
    protected $lastStatusTimestamp;
    protected $place;
    protected $calibratingCo2;
    protected $wifiSignalQuality;
    protected $measureTypes;
    protected $modules = [];

    public function getLastStatusTimestamp()
    {
        return $this->lastStatusTimestamp;
    }

    public function getWifiSignalQuality()
    {
        return $this->wifiSignalQuality;
    }

    public function getPlace()
    {
        return $this->place;
    }

    public function getMeasureTypes()
    {
        return $this->measureTypes;
    }

    public function getBatteryLevel()
    {
        return $this->batteryLevel;
    }

    public function getModules()
    {
        return $this->modules;
    }

    public function setLastStatusTimestamp($ts)
    {
        $this->lastStatusTimestamp = $ts;
    }

    public function setWifiSignalQuality($rssi)
    {
        $this->wifiSignalQuality = $rssi;
    }

    public function setPlace($place)
    {
        $this->place = $place;
    }

    public function setCo2Calibration($flag)
    {
        $this->calibratingCo2 = $flag;
    }

    public function isCalibratingCo2()
    {
        return $this->calibratingCo2;
    }

    public function setMeasureTypes(array $types)
    {
        $this->measureTypes = $types;
    }

    public function addModule(Module $module)
    {
        $this->modules[] = $module;
    }
}
