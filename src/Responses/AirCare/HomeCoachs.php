<?php

namespace Netatmo\Sdk\Responses\AirCare;

use Netatmo\Sdk\Models;
use Netatmo\Sdk\Responses;

class HomeCoachs extends Responses\Response
{
    protected $homeCoachs = [];
    protected $user;

    public function getUser()
    {
        return $this->user;
    }

    public function getHomeCoachs()
    {
        return $this->homeCoachs;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function addHomeCoach(Models\AirCare\HomeCoach $homeCoach)
    {
        $this->homeCoachs[] = $homeCoach;
    }
}
