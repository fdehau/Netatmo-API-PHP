<?php

namespace Netatmo\Sdk\Responses;

class Response
{
    protected $timestamp;

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function setTimestamp($ts)
    {
        $this->timestamp = $ts;
    }
}
