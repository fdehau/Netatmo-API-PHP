<?php

namespace Netatmo\Sdk\Serialization\Models\Schedules;

use Netatmo\Sdk\Serialization;
use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Models;

class EnergyScheduleSerializer extends ScheduleSerializer
{
    const TYPE = "type";
    const AWAY_TEMPERATURE = "away_temp";
    const FROSTGUARD_TEMPERATURE = "hg_temp";

    public function getRoomSerializer()
    {
        return new Serialization\Models\Schedules\EnergyRoomSerializer();
    }

    public function canSerialize($object)
    {
        return $object instanceof Models\Schedules\EnergySchedule;
    }

    public function __toArray($schedule)
    {
        $array = parent::__toArray($schedule);
        $array[self::TYPE] = "therm";
        $awayTemperature = $schedule->getAwayTemperature();
        if ($awayTemperature !== null) {
            $array[self::AWAY_TEMPERATURE] = $awayTemperature;
        }

        $frostguardTemperature = $schedule->getFrostguardTemperature();
        if ($frostguardTemperature !== null) {
            $array[self::FROSTGUARD_TEMPERATURE] = $frostguardTemperature;
        }
        return $array;
    }
}
