<?php

namespace Netatmo\Sdk\Serialization\Models\Weather;

use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Models;
use Netatmo\Sdk\Serialization;

class ModuleDeserializer implements Serialization\ArrayDeserializer
{
    const ID = "_id";
    const TYPE = "type";
    const BATTERY_LEVEL = "battery_vp";
    const BATTERY_PERCENTAGE = "battery_percent";
    const RADIO_SIGNAL_QUALITY = "rf_status";
    const RADIO_LAST_MESSAGE = "last_message";
    const RADIO_LAST_SEEN = "last_seen";
    const MEASURES = "dashboard_data";

    const OUTDOOR_MODULE = "NAModule1";
    const WIND_GAUGE = "NAModule2";
    const RAIN_GAUGE = "NAModule3";
    const INDOOR_MODULE = "NAModule4";

    public function fromArray(array $array)
    {
        // Create module
        if (!isset($array[self::ID])) {
            throw new Exceptions\Error("Missing id inside module");
        }
        if (!isset($array[self::TYPE])) {
            throw new Exceptions\Error("Missing type inside module");
        }
        $module = $this->getModuleByType(
            $array[self::ID],
            $array[self::TYPE]
        );

        // Parse battery
        if (isset($array[self::BATTERY_LEVEL])) {
            $battery = new Models\Battery($array[self::BATTERY_LEVEL]);
            if (isset($array[self::BATTERY_PERCENTAGE])) {
                $battery->setPercentage($array[self::BATTERY_PERCENTAGE]);
            }
            $module->setBattery($battery);
        }

        // Parse radio
        if (isset($array[self::RADIO_SIGNAL_QUALITY])) {
            $radio  = new Models\Radio($array[self::RADIO_SIGNAL_QUALITY]);
            if (isset($array[self::RADIO_LAST_SEEN])) {
                $radio->setLastSeen($array[self::RADIO_LAST_SEEN]);
            }
            if (isset($array[self::RADIO_LAST_MESSAGE])) {
                $radio->setLastMessage($array[self::RADIO_LAST_MESSAGE]);
            }
            $module->setRadio($radio);
        }

        // Parser measures snapshot
        if (isset($array[self::MEASURES])) {
            $de = $this->getMeasuresDeserializerByType($array[self::TYPE]);
            $measures = $de->fromArray($array[self::MEASURES]);
            $module->setMeasures($measures);
        }

        return $module;
    }

    public function getModuleByType($id, $type)
    {
        switch ($type) {
            case self::OUTDOOR_MODULE:
                return new Models\Weather\OutdoorModule($id);
            case self::WIND_GAUGE:
                return new Models\Weather\WindGauge($id);
            case self::RAIN_GAUGE:
                return new Models\Weather\RainGauge($id);
            case self::INDOOR_MODULE:
                return new Models\Weather\IndoorModule($id);
            default:
                throw Exceptions\Error("Invalid module type");
        }
    }

    public function getMeasuresDeserializerByType($type)
    {
        switch ($type) {
            case self::OUTDOOR_MODULE:
                return new Serialization\Models\Weather\OutdoorMeasuresDeserializer();
            case self::WIND_GAUGE:
                return new Serialization\Models\Weather\WindMeasuresDeserializer();
            case self::RAIN_GAUGE:
                return new Serialization\Models\Weather\RainMeasuresDeserializer();
            default:
                return new Serialization\Models\Weather\MeasuresDeserializer();
        }
    }
}
