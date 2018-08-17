<?php

namespace Netatmo\Sdk\Models;

class Place
{
    protected $altitude;
    protected $city;
    protected $country;
    protected $timezone;
    protected $latitude;
    protected $longitude;

    public function getAltitude()
    {
        return $this->altitude;
    }
    public function getCity()
    {
        return $this->city;
    }
    public function getCountry()
    {
        return $this->country;
    }
    public function getTimezone()
    {
        return $this->timezone;
    }
    public function getLatitude()
    {
        return $this->latitude;
    }
    public function getLongitude()
    {
        return $this->longitude;
    }
    public function setAltitude($altitude)
    {
        $this->altitude = $altitude;
    }
    public function setCity($city)
    {
        $this->city = $city;
    }
    public function setCountry($country)
    {
        $this->country = $country;
    }
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;
    }
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }
}
