<?php

namespace Netatmo\Sdk\Serialization\Models\AirCare;

use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Serialization;
use Netatmo\Sdk\Models;

class HomeCoachDeserializer implements Serialization\ArrayDeserializer
{
    const ID = "_id";
    const LAST_STATUS_TIMESTAMP = "last_status_store";
    const PLACE = "place";
    const NAME = "station_name";
    const CALIBRATING_CO2 = "co2_calibrating";
    const FIRST_SETUP = "date_setup";
    const LAST_SETUP = "last_setup";
    const LAST_FIRMWARE_UPDATE = "last_upgrade";
    const FIRMWARE_VERSION = "firmware";
    const WIFI_SIGNAL_QUALITY = "wifi_status";
    const MEASURE_TYPES = "data_type";

    public function fromArray(array $array)
    {
        if (!isset($array[self::ID])) {
            throw new Exceptions\Error("Missing id inside device");
        }
        $homeCoach = new Models\AirCare\HomeCoach($array[self::ID]);
        if (isset($array[self::LAST_STATUS_TIMESTAMP])) {
            $homeCoach->setLastStatusTimestamp($array[self::LAST_STATUS_TIMESTAMP]);
        }
        if (isset($array[self::NAME])) {
            $homeCoach->setName($array[self::NAME]);
        }
        if (isset($array[self::PLACE])) {
            $de = new Serialization\Models\PlaceDeserializer();
            $place = $de->fromArray($array[self::PLACE]);
            $homeCoach->setPlace($place);
        }
        if (isset($array[self::CALIBRATING_CO2])) {
            $homeCoach->setCo2Calibration($array[self::CALIBRATING_CO2]);
        }
        if (isset($array[self::LAST_SETUP])) {
            $installation = new Models\Installation($array[self::LAST_SETUP]);
            if (isset($array[self::FIRST_SETUP])) {
                $installation->setFirstSetup($array[self::FIRST_SETUP]);
            }
            $homeCoach->setInstallation($installation);
        }
        if (isset($array[self::FIRMWARE_VERSION])) {
            $firmware = new Models\Firmware($array[self::FIRMWARE_VERSION]);
            if (isset($array[self::LAST_FIRMWARE_UPDATE])) {
                $firmware->setLastUpdate($array[self::LAST_FIRMWARE_UPDATE]);
            }
            $homeCoach->setFirmware($firmware);
        }
        if (isset($array[self::WIFI_SIGNAL_QUALITY])) {
            $homeCoach->setWifiSignalQuality($array[self::WIFI_SIGNAL_QUALITY]);
        }
        if (isset($array[self::MEASURE_TYPES])) {
            $homeCoach->setMeasureTypes($array[self::MEASURE_TYPES]);
        }
        return $homeCoach;
    }
}
