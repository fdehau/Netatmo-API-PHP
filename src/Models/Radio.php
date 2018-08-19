<?php

namespace Netatmo\Sdk\Models;

class Radio
{
    protected $signalQuality;
    protected $lastMessage;
    protected $lastSeen;

    public function __construct($rssi)
    {
        $this->signalQuality = $rssi;
    }

    public function getSignalQuality()
    {
        return $this->signalQuality;
    }

    public function getLastMessage()
    {
        return $this->lastMessage;
    }

    public function getLastSeen()
    {
        return $this->lastSeen;
    }

    public function setLastMessage($ts)
    {
        $this->lastMessage = $ts;
    }

    public function setLastSeen($ts)
    {
        $this->lastSeen = $ts;
    }
}
