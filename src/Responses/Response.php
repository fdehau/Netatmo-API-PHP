<?php

namespace Netatmo\Responses;

abstract class Response
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

    abstract public function fromArray();
}
