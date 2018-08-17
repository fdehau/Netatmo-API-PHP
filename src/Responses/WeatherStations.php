<?php

namespace Netatmo\Sdk\Responses;

use Netatmo\Sdk\Models;

class WeatherStations extends Response
{
    protected $stations = [];
    protected $user;

    public function getUser()
    {
        return $this->user;
    }

    public function getStations()
    {
        return $this->stations;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function addStation(Models\WeatherStation $station)
    {
        $this->stations[] = $station;
    }
}
