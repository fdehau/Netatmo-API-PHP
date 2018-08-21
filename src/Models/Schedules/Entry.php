<?php

namespace Netatmo\Sdk\Models\Schedules;

class Entry
{
    protected $offset;
    protected $zone;

    public function __construct($offset, $zone)
    {
        $this->offset = $offset;
        $this->zone = $zone;
    }

    public function getOffset()
    {
        return $this->offset;
    }

    public function getZone()
    {
        return $this->zone;
    }
}
