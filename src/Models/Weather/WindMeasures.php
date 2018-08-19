<?php

namespace Netatmo\Sdk\Models\Weather;

use Netatmo\Sdk\Models;

class WindMeasures extends Measures
{
    protected $windStrength;
    protected $windAngle;
    protected $gustStrength;
    protected $gustAngle;

    public function getWindStrength()
    {
        return $this->windStrength;
    }

    public function getWindAngle()
    {
        return $this->windAngle;
    }

    public function getGustStrength()
    {
        return $this->gustStrength;
    }

    public function getGustAngle()
    {
        return $this->gustAngle;
    }

    public function setWindStrength($windStrength)
    {
        $this->windStrength = $windStrength;
    }

    public function setWindAngle($windAngle)
    {
        $this->windAngle = $windAngle;
    }

    public function setGustStrength($gustStrength)
    {
        $this->gustStrength = $gustStrength;
    }

    public function setGustAngle($gustAngle)
    {
        $this->gustAngle = $gustAngle;
    }
}
