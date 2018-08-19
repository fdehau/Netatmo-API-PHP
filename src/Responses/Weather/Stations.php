<?php

namespace Netatmo\Sdk\Responses\Weather;

use Netatmo\Sdk\Models;
use Netatmo\Sdk\Responses;

class Stations extends Responses\Response
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

    public function addStation(Models\Weather\Station $station)
    {
        $this->stations[] = $station;
    }
}
