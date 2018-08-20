<?php

namespace Netatmo\Sdk\Models;

class Gateway extends Device
{
    protected $modules;

    public function addModule($id)
    {
        $this->modules[] = $id;
    }

    public function getModules()
    {
        return $this->modules;
    }
}
