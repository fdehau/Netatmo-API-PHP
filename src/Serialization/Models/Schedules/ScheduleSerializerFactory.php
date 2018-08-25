<?php

namespace Netatmo\Sdk\Serialization\Models\Schedules;

use Netatmo\Sdk\Serialization;
use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Models;

class ScheduleSerializerFactory
{
    public static function fromSchedule(Models\Schedules\Schedule $schedule)
    {
        if ($schedule instanceof Models\Schedules\EnergySchedule) {
            return new EnergyScheduleSerializer();
        } else {
            return new ScheduleSerializer();
        }
    }
}
