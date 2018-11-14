<?php

namespace Netatmo\Sdk\Requests;

use Netatmo\Sdk\Http;
use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Serialization;
use Netatmo\Sdk\Requests;
use Netatmo\Sdk\Models;

class RenameSchedule implements Requests\Request
{
    public function __construct(Models\Schedules\Schedule $schedule)
    {
        $this->schedule = $schedule;
    }

    public function getPath()
    {
        return "api/renamehomeschedule";
    }

    public function getMethod()
    {
        return Http\Method::POST;
    }

    public function getParams()
    {
        $params = [
            "home_id" => $this->schedule->getHomeId(),
            "schedule_id" => $this->schedule->getId(),
        ];
        if ($this->schedule->hasName()) {
            $params["name"] = $this->schedule->getName();
        }
        return $params;
    }

    public function withAuthorization()
    {
        return true;
    }

    public function getResponseDeserializer()
    {
        return new Serialization\Responses\BaseDeserializer();
    }
}
