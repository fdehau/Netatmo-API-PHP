<?php

namespace Netatmo\Sdk\Serialization\Models;

use Netatmo\Sdk\Serialization;
use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Models;

class HomeDeserializer implements Serialization\ArrayDeserializer
{
    const ID = "id";
    const NAME = "name";
    const ROOMS = "rooms";
    const MODULES = "modules";
    const SCHEDULES = "schedules";

    public function fromArray(array $array)
    {
        if (!isset($array[self::ID])) {
            throw new Exceptions\Error("Missing id");
        }
        $home = new Models\Home($array[self::ID]);

        if (isset($array[self::NAME])) {
            $home->setName($array[self::NAME]);
        }

        $de = new PlaceDeserializer(PlaceDeserializer::COORDINATES);
        $place = $de->fromArray($array);
        $home->setPlace($place);

        if (isset($array[self::ROOMS]) && is_array($array[self::ROOMS])) {
            $de = new RoomDeserializer();
            foreach ($array[self::ROOMS] as $room) {
                $room = $de->fromArray($room);
                $home->addRoom($room);
            }
        }

        if (isset($array[self::MODULES]) && is_array($array[self::MODULES])) {
            foreach ($array[self::MODULES] as $module) {
                if (!isset($module["type"])) {
                    throw new Exceptions\Error("Missing type");
                }
                $de = $this->getModuleDeserializerByType($module["type"]);
                $module = $de->fromArray($module);
                $home->addModule($module);
            }
        }

        if (isset($array[self::SCHEDULES]) && is_array($array[self::SCHEDULES])) {
            foreach ($array[self::SCHEDULES] as $schedule) {
                if (!isset($schedule["type"])) {
                    throw new Exceptions\Error("Missing type");
                }
                $de = $this->getScheduleDeserializerByType($schedule["type"]);
                $schedule = $de->fromArray($schedule);
                $home->addSchedule($schedule);
            }
        }

        return $home;
    }

    public function getModuleDeserializerByType($type)
    {
        switch ($type) {
            case "NAPlug":
                return new Serialization\Models\Energy\RelayDeserializer();
            case "NATherm1":
                return new Serialization\Models\Energy\ThermostatDeserializer();
            case "NRV":
                return new Serialization\Models\Energy\ValveDeserializer();
            default:
                return new Serialization\Models\DeviceDeserializer();
        }
    }

    public function getScheduleDeserializerByType($type)
    {
        switch ($type) {
            case "therm":
                return new Serialization\Models\Schedules\EnergyScheduleDeserializer();
            default:
                return new Serialization\Models\Schedules\ScheduleDeserializer();
        }
    }
}