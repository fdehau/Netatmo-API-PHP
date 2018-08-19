<?php

namespace Netatmo\Sdk\Responses;

class Response
{
    protected $timestamp;
    protected $requestExecutionTime;

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function getRequestExecutionTime()
    {
        return $this->requestExecutionTime;
    }

    public function setTimestamp($ts)
    {
        $this->timestamp = $ts;
    }

    public function setRequestExecutionTime($time)
    {
        $this->requestExecutionTime = $time;
    }
}
