<?php

namespace Netatmo\Sdk\Models;

abstract class Device
{
    protected $id;
    protected $name;
    protected $installation;
    protected $firmware;

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

    public function getFirmware()
    {
        return $this->firmware;
    }

    public function getInstallation()
    {
        return $this->installation;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setFirmware(Firmware $firmware)
    {
        $this->firmware = $firmware;
    }

    public function setInstallation(Installation $installation)
    {
        $this->installation = $installation;
    }
}
