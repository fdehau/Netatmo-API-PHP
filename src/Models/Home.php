<?php

namespace Netatmo\Sdk\Models;

class Home
{
    protected $id;
    protected $name;
    protected $place;
    protected $rooms = [];
    protected $modules = [];
    protected $schedules = [];
    protected $thermostatMode;
    protected $thermostatSettings;

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

    public function getSchedules()
    {
        return $this->schedules;
    }

    public function getThermostatMode()
    {
        return $this->thermostatMode;
    }

    public function getThermostatSettings()
    {
        return $this->thermostatSettings;
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

    public function addSchedule(Schedules\Schedule $schedule)
    {
        $this->schedules[] = $schedule;
    }

    public function setThermostatMode(Energy\ThermostatMode $mode)
    {
        $this->thermostatMode = $mode;
    }

    public function setThermostatSettings(Energy\ThermostatSettings $settings)
    {
        $this->thermostatSettings = $settings;
    }
}
