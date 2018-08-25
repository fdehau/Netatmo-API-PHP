<?php

namespace Netatmo\Sdk\Requests;

use Netatmo\Sdk\Http;
use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Serialization;
use Netatmo\Sdk\Requests;
use Netatmo\Sdk\Models;

class CreateSchedule implements Requests\Request
{
    public function __construct(Models\Schedules\Schedule $schedule)
    {
        $this->schedule = $schedule;
    }

    public function getPath()
    {
        return "api/createnewhomeschedule";
    }

    public function getMethod()
    {
        return Http\Method::POST;
    }

    public function getParams()
    {
        $de = Serialization\Models\Schedules\ScheduleSerializerFactory::fromSchedule($this->schedule);
        return $de->toArray($this->schedule);
    }

    public function withAuthorization()
    {
        return true;
    }

    public function getResponseDeserializer()
    {
        return new Serialization\Responses\EmptyDeserializer();
    }
}
