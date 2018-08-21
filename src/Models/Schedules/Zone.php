<?php

namespace Netatmo\Sdk\Models\Schedules;

class Zone
{
    protected $id;
    protected $type;
    protected $name;
    protected $rooms;

    public function __construct($id, $type)
    {
        $this->id = $id;
        $this->type = $type;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getRooms()
    {
        return $this->rooms;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function addRoom(Room $room)
    {
        $this->rooms[] = $room;
    }
}
