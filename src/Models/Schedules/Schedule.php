<?php

namespace Netatmo\Sdk\Models\Schedules;

class Schedule
{
    protected $id;
    protected $name;
    protected $default;
    protected $timetable = [];
    protected $zones = [];

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

    public function isDefault()
    {
        return $this->default;
    }

    public function getTimetable()
    {
        return $this->timetable;
    }

    public function getZones()
    {
        return $this->zones;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setDefault($flag)
    {
        $this->default = $flag;
    }

    public function setTimetable(array $timetable)
    {
        $this->timetable = $timetable;
    }

    public function addEntry(Entry $entry)
    {
        $this->timetable[] = $entry;
    }

    public function addZone(Zone $zone)
    {
        $this->zones[] = $zone;
    }
}
