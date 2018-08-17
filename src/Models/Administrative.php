<?php

namespace Netatmo\Sdk\Models;

class Administrative
{
    protected $lang;
    protected $locale;
    protected $country;
    protected $unit;
    protected $windunit;
    protected $pressureunit;
    protected $feelLikeAlgo;

    public function getLang()
    {
        return $this->lang;
    }

    public function getLocale()
    {
        return $this->locale;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function getUnit()
    {
        return $this->unit;
    }

    public function getWindUnit()
    {
        return $this->windUnit;
    }

    public function getPressureUnit()
    {
        return $this->pressureUnit;
    }

    public function getFeelLikeAlgo()
    {
        return $this->feelLikeAlgo;
    }

    public function setLang($lang)
    {
        $this->lang = $lang;
    }

    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    public function setCountry($country)
    {
        $this->country = $country;
    }

    public function setUnit($unit)
    {
        $this->unit = $unit;
    }

    public function setWindUnit($unit)
    {
        $this->windUnit = $unit;
    }

    public function setPressureUnit($unit)
    {
        $this->pressureUnit = $unit;
    }

    public function setFeelLikeAlgo($algo)
    {
        $this->feelLikeAlgo = $algo;
    }
}
