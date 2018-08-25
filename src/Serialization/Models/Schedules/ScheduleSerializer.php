<?php

namespace Netatmo\Sdk\Serialization\Models\Schedules;

use Netatmo\Sdk\Serialization;
use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Models;

abstract class ScheduleSerializer extends Serialization\ArraySerializer
{
    const ID = "schedule_id";
    const HOME_ID = "home_id";
    const NAME = "name";
    const __DEFAULT = "default";
    const ZONES = "zones";
    const TIMETABLE = "timetable";

    abstract public function getRoomSerializer();

    public function getSerializedClass()
    {
        return Models\Schedules\Schedule::class;
    }

    public function __toArray($schedule)
    {
        $array = [
            self::ID => $schedule->getId(),
            self::HOME_ID => $schedule->getHomeId(),
        ];

        $de = new TimetableSerializer();
        $array[self::TIMETABLE] = $de->toArray($schedule->getTimetable());

        $default = $schedule->isDefault();
        if ($default !== null) {
            $array[self::__DEFAULT] = $default;
        }

        $name = $schedule->getName();
        if ($name !== null) {
            $array[self::NAME] = $name;
        }

        $zones = [];
        $de = new ZoneSerializer($this->getRoomSerializer());
        foreach ($schedule->getZones() as $zone) {
            $zones[] = $de->toArray($zone);
        }
        $array[self::ZONES] = $zones;

        return $array;
    }
}
