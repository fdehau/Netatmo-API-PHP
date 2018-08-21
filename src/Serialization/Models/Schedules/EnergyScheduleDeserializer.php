<?php

namespace Netatmo\Sdk\Serialization\Models\Schedules;

use Netatmo\Sdk\Serialization;
use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Models;

class EnergyScheduleDeserializer extends ScheduleDeserializer
{
    const AWAY_TEMPERATURE = "away_temp";
    const FROSTGUARD_TEMPERATURE = "hg_temp";

    public function getScheduleClass()
    {
        return Models\Schedules\EnergySchedule::class;
    }

    public function getRoomDeserializer()
    {
        return new Serialization\Models\Schedules\EnergyRoomDeserializer();
    }

    public function fromArray(array $array)
    {
        $schedule = parent::fromArray($array);
        if (isset($array[self::AWAY_TEMPERATURE])) {
            $schedule->setAwayTemperature($array[self::AWAY_TEMPERATURE]);
        }
        if (isset($array[self::FROSTGUARD_TEMPERATURE])) {
            $schedule->setFrostguardTemperature($array[self::FROSTGUARD_TEMPERATURE]);
        }
        return $schedule;
    }
}
