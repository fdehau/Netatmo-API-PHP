<?php

namespace Netatmo\Sdk\Models;

class Module extends Device
{
    protected $bridge;

    public function getBridge()
    {
        return $this->bridge;
    }

    public function setBridge($bridge)
    {
        $this->bridge = $bridge;
    }
}
