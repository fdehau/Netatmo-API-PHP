<?php

namespace Netatmo\Sdk\Models;

class Installation
{
    protected $firstSetup;
    protected $lastSetup;

    public function __construct($lastSetup)
    {
        $this->lastSetup = $lastSetup;
    }

    public function getLastSetup()
    {
        return $this->lastSetup;
    }

    public function getFirstSetup()
    {
        return $this->firstSetup;
    }

    public function setFirstSetup($ts)
    {
        $this->firstSetup = $ts;
    }
}
