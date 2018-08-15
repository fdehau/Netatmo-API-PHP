<?php

namespace Netatmo\Http;

class Options
{
    /**
     * @var integer
     */
    const DEFAULT_TIMEOUT = 5;

    /**
     * Timeout for an HTTP request
     */
    protected $timeout;

    public function __construct()
    {
        $this->timeout = self::DEFAULT_TIMEOUT;
    }

    public function getTimeout()
    {
        return $this->timeout;
    }

    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
    }
}
