<?php

namespace Netatmo\Sdk\Models;

class Home
{
    protected $id;
    protected $name;
    protected $place;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPlace()
    {
        return $this->place;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setPlace(Place $place)
    {
        $this->place = $place;
    }
}
