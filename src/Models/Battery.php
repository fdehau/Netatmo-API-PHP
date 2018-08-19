<?php

namespace Netatmo\Sdk\Models;

use Netatmo\Sdk\Exceptions;

class Battery
{
    protected $level;
    protected $percentage;

    public function __construct($level)
    {
        $this->level = $level;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function getPercentage()
    {
        return $this->percentage;
    }

    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;
    }
}
