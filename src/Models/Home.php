<?php

namespace Netatmo\Sdk\Models;

class Home
{
    protected $id;
    protected $name;
    protected $place;
    protected $rooms = [];
    protected $modules = [];

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

    public function getRooms()
    {
        return $this->rooms;
    }

    public function getModules()
    {
        return $this->modules;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setPlace(Place $place)
    {
        $this->place = $place;
    }

    public function addRoom(Room $room)
    {
        $this->rooms[] = $room;
    }

    public function addModule(Device $device)
    {
        $this->modules[] = $device;
    }
}
