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

    public static function fromArray(array $array, array $options)
    {
        return new self();
    }
}
