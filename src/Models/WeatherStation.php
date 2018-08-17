<?php

namespace Netatmo\Models;

use Netatmo\Exceptions;

class WeatherStation
{
    protected $id;
    protected $lastStatusTimestamp;
    protected $place;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLastStatusTimestamp()
    {
        return $this->lastStatusTimestamp;
    }

    public function getPlace()
    {
        return $this->place;
    }

    public function setLastStatusTimestamp($ts)
    {
        $this->lastStatusTimestamp = $ts;
    }

    public function setPlace($place)
    {
        $this->place = $place;
    }
}
