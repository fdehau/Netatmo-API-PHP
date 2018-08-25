<?php

namespace Netatmo\Sdk\Serialization\Models\Schedules;

use Netatmo\Sdk\Serialization;
use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Models;

class TimetableSerializer extends Serialization\ArraySerializer
{
    const OFFSET = "m_offset";
    const ZONE = "zone_id";

    public function canSerialize($object)
    {
        return is_array($object);
    }

    public function __toArray($timetable)
    {
        return array_map(
            function ($e) {
                return [
                    self::OFFSET => $e->getOffset(),
                    self::ZONE => $e->getZone()
                ];
            },
            $timetable
        );
    }
}
