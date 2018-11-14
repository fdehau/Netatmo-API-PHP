<?php

namespace Netatmo\Sdk\Responses;

class Response
{
    protected $timestamp;
    protected $requestExecutionTime;
    protected $body;

    public function __construct(array $body = [])
    {
        $this->body = $body;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function getRequestExecutionTime()
    {
        return $this->requestExecutionTime;
    }

    public function getBody()
    {
        return $this->body;
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
