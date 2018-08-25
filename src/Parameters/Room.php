<?php

namespace Netatmo\Sdk\Parameters;

class Room
{
    public function __construct($id, $homeId)
    {
        $this->id = $id;
        $this->homeId = $homeId;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getHomeId()
    {
        return $this->homeId;
    }
}
