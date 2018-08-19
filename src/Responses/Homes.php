<?php

namespace Netatmo\Sdk\Responses;

use Netatmo\Sdk\Models;

class Homes extends Response
{
    protected $user;
    protected $homes = [];

    public function getHomes()
    {
        return $this->homes;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(Models\User $user)
    {
        $this->user = $user;
    }

    public function addHome(Models\Home $home)
    {
        $this->homes[] = $home;
    }
}
