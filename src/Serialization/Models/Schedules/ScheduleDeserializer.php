<?php

namespace Netatmo\Sdk\Serialization\Models\Schedules;

use Netatmo\Sdk\Serialization;
use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Models;

abstract class ScheduleDeserializer implements Serialization\ArrayDeserializer
{
    const ID = "id";
    const NAME = "name";
    const __DEFAULT = "default";
    const ZONES = "zones";
    const TIMETABLE = "timetable";

    abstract public function getScheduleClass();
    abstract public function getRoomDeserializer();

    public function fromArray(array $array)
    {
        if (!isset($array[self::ID])) {
            throw new Exceptions\Error("Missing id");
        }
        $class = $this->getScheduleClass();
        $schedule = new $class($array[self::ID]);

        if (isset($array[self::NAME])) {
            $schedule->setName($array[self::NAME]);
        }

        if (isset($array[self::__DEFAULT])) {
            $schedule->setDefault($array[self::__DEFAULT]);
        }

        if (isset($array[self::TIMETABLE]) && is_array($array[self::TIMETABLE])) {
            $de = new TimetableDeserializer();
            $timetable = $de->fromArray($array[self::TIMETABLE]);
            $schedule->setTimetable($timetable);
        }

        if (isset($array[self::ZONES]) && is_array($array[self::ZONES])) {
            $de = new ZoneDeserializer($this->getRoomDeserializer());
            foreach ($array[self::ZONES] as $zone) {
                $zone = $de->fromArray($zone);
                $schedule->addZone($zone);
            }
        }

        return $schedule;
    }
}
