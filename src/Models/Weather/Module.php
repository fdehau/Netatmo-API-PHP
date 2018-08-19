<?php

namespace Netatmo\Sdk\Models\Weather;

use Netatmo\Sdk\Models;

class Module extends Models\Device
{
    protected $battery;
    protected $radio;
    protected $measures;

    public function getBattery()
    {
        return $this->battery;
    }

    public function getRadio()
    {
        return $this->radio;
    }

    public function getMeasures()
    {
        return $this->measures;
    }

    public function setBattery(Models\Battery $battery)
    {
        $this->battery = $battery;
    }

    public function setRadio(Models\Radio $radio)
    {
        $this->radio = $radio;
    }

    public function setMeasures(Measures $measures)
    {
        $this->measures = $measures;
    }
}
