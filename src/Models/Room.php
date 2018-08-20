<?php

namespace Netatmo\Sdk\Models;

class Room
{
    protected $id;
    protected $name;
    protected $type;
    protected $modules;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getModules()
    {
        return $this->modules;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function addModule($moduleId)
    {
        $this->modules[] = $moduleId;
    }
}
