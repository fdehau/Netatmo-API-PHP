<?php

namespace Netatmo\Sdk\Serialization\Models\Schedules;

use Netatmo\Sdk\Serialization;
use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Models;

class TimetableDeserializer implements Serialization\ArrayDeserializer
{
    const OFFSET = "m_offset";
    const ZONE = "zone_id";

    public function fromArray(array $array)
    {
        $timetable = [];
        foreach ($array as $entry) {
            if (!isset($entry[self::OFFSET])) {
                throw new Exceptions\Error("Missing offset");
            }
            if (!isset($entry[self::ZONE])) {
                throw new Exceptions\Error("Missing zone");
            }
            $entry = new Models\Schedules\Entry(
                $entry[self::OFFSET],
                $entry[self::ZONE]
            );
            $timetable[] = $entry;
        }
        return $timetable;
    }
}
