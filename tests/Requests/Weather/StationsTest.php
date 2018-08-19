<?php

namespace Netatmo\Sdk\Tests\Requests\Weather;

use Netatmo\Sdk\Client;
use Netatmo\Sdk\Requests;
use Netatmo\Sdk\Responses;
use Netatmo\Sdk\Models;
use Netatmo\Sdk\Tests\Fixtures;
use PHPUnit\Framework\TestCase;

class StationsTest extends TestCase
{
    public function testGetWeatherStations()
    {
        $client = Fixtures\Client::withResponses([
            new Fixtures\Responses\Ok(
                [
                    "user" => [
                        "mail" => "florian@netatmo.com",
                        "administrative" => [
                            "lang" => "fr-FR",
                            "reg_locale" => "fr-FR",
                            "country" => "FR",
                            "unit" => 1,
                            "windunit" => 1,
                            "pressureunit" => 1,
                        ]
                    ],
                    "devices" => [
                        [
                            "_id" => "70:ee:50:2c:70:ca",
                            "last_status_store" => 3600,
                            "station_name" => "Indoor",
                            "date_setup" => 1200,
                            "last_setup" => 1800,
                            "firmware" => 100,
                            "last_upgrade" => 2000,
                            "data_type" => [
                                "Temperature",
                                "Humidity"
                            ],
                            "place" => [
                                "altitude" => 20,
                                "country" => "FR",
                                "city" => "Paris",
                                "timezone" => "Europe/Paris",
                                "location" => [
                                    2.23,
                                    48.88
                                ]
                            ],
                            "wifi_status" => 70,
                            "modules" => [
                                [
                                    "_id" => "02:00:00:2c:00:00",
                                    "type" => "NAModule1",
                                    "battery_vp" => 5590,
                                    "battery_percent" => 95,
                                    "last_seen" => 15000,
                                    "last_message" => 15000,
                                    "rf_status" => 9,
                                    "dashboard_data" => [
                                        "time_utc" => 15000,
                                        "Temperature" => 23,
                                        "Humidity" => 42,
                                        "max_temp" => 33,
                                        "date_max_temp" => 8000,
                                        "min_temp" => 23,
                                        "date_min_temp" => 7000,
                                    ]
                                ],
                                [
                                    "_id" => "02:00:00:2c:00:01",
                                    "type" => "NAModule2",
                                    "battery_vp" => 5590,
                                    "battery_percent" => 95,
                                    "last_seen" => 15000,
                                    "last_message" => 15000,
                                    "rf_status" => 9,
                                    "dashboard_data" => [
                                        "time_utc" => 15000,
                                        "WindStrength" => 20,
                                        "WindAngle" => 45,
                                        "GustStrength" => 40,
                                        "GustAngle" => 90,
                                    ]
                                ],
                                [
                                    "_id" => "02:00:00:2c:00:02",
                                    "type" => "NAModule3",
                                    "battery_vp" => 5590,
                                    "battery_percent" => 95,
                                    "last_seen" => 15000,
                                    "last_message" => 15000,
                                    "rf_status" => 9,
                                    "dashboard_data" => [
                                        "time_utc" => 15000,
                                        "sum_rain_1" => 500,
                                        "sum_rain_24" => 1000,
                                    ]
                                ],
                            ],
                            "dashboard_data" => [
                                "time_utc" => 15000,
                                "Temperature" => 23,
                                "CO2" => 1000,
                                "Humidity" => 42,
                                "pressure_trend" => "stable",
                                "AbsolutePressure" => 1033.2,
                                "pressure" => 1026.4,
                                "Noise" => 53,
                            ]
                        ]
                    ]
                ]
            )
        ]);

        $request = Requests\Weather\Stations::getDevice("70:ee:50:2c:70:ca")
            ->includeFavorites();
        $response = $client->send($request);
        $this->assertInstanceOf(
            Responses\Weather\Stations::class,
            $response
        );

        // Check user
        $user = $response->getUser();
        $this->assertEquals("florian@netatmo.com", $user->getEmail());
        $administrative = $user->getAdministrative();
        $this->assertEquals("fr-FR", $administrative->getLang());
        $this->assertEquals("fr-FR", $administrative->getLocale());
        $this->assertEquals("FR", $administrative->getCountry());
        $this->assertEquals(1, $administrative->getUnit());
        $this->assertEquals(1, $administrative->getWindUnit());
        $this->assertEquals(1, $administrative->getPressureUnit());

        $stations = $response->getStations();
        $this->assertCount(1, $stations);

        $station = $stations[0];
        $this->assertEquals("70:ee:50:2c:70:ca", $station->getId());
        $this->assertEquals(3600, $station->getLastStatusTimestamp());
        $this->assertEquals("Indoor", $station->getName());

        $installation = $station->getInstallation();
        $this->assertNotNull($installation);
        $this->assertEquals(1200, $installation->getFirstSetup());
        $this->assertEquals(1800, $installation->getLastSetup());

        $firmware = $station->getFirmware();
        $this->assertNotNull($firmware);
        $this->assertEquals(100, $firmware->getVersion());
        $this->assertEquals(2000, $firmware->getLastUpdate());

        $this->assertEquals(70, $station->getWifiSignalQuality());
        $this->assertEquals(
            ["Temperature", "Humidity"],
            $station->getMeasureTypes()
        );

        // Check place
        $place = $station->getPlace();
        $this->assertEquals(2.23, $place->getLongitude());
        $this->assertEquals(48.88, $place->getLatitude());
        $this->assertEquals(20, $place->getAltitude());
        $this->assertEquals("FR", $place->getCountry());
        $this->assertEquals("Paris", $place->getCity());
        $this->assertEquals("Europe/Paris", $place->getTimezone());

        $measures = $station->getMeasures();
        $this->assertInstanceOf(
            Models\Weather\Measures::class,
            $measures
        );
        $this->assertEquals(15000, $measures->getTimestamp());
        $this->assertEquals(23, $measures->getTemperature());
        $this->assertEquals(42, $measures->getHumidity());
        $this->assertEquals(1000, $measures->getCo2());
        $pressure = $measures->getPressure();
        $this->assertEquals(1026.4, $pressure->getValue());
        $this->assertEquals(1033.2, $pressure->getAbsoluteValue());
        $this->assertEquals("stable", $pressure->getTrend());
        $this->assertEquals(53, $measures->getNoise());

        $modules = $station->getModules();
        $this->assertCount(3, $modules);

        // Check outdoor module
        $outdoorModule = $modules[0];
        $this->assertInstanceOf(
            Models\Weather\OutdoorModule::class,
            $outdoorModule
        );
        $this->assertEquals("02:00:00:2c:00:00", $outdoorModule->getId());

        $battery = $outdoorModule->getBattery();
        $this->assertEquals(5590, $battery->getLevel());
        $this->assertEquals(95, $battery->getPercentage());

        $radio = $outdoorModule->getRadio();
        $this->assertEquals(9, $radio->getSignalQuality());
        $this->assertEquals(15000, $radio->getLastSeen());
        $this->assertEquals(15000, $radio->getLastMessage());

        $measures = $outdoorModule->getMeasures();
        $this->assertInstanceOf(
            Models\Weather\Measures::class,
            $measures
        );
        $this->assertEquals(15000, $measures->getTimestamp());
        $this->assertEquals(23, $measures->getTemperature());
        $this->assertEquals(42, $measures->getHumidity());
        $this->assertEquals(33, $measures->getMaxTemperature()->getValue());
        $this->assertEquals(8000, $measures->getMaxTemperature()->getTimestamp());
        $this->assertEquals(23, $measures->getMinTemperature()->getValue());
        $this->assertEquals(7000, $measures->getMinTemperature()->getTimestamp());

        // Check rain gauge
        $rainGauge = $modules[1];
        $this->assertInstanceOf(
            Models\Weather\WindGauge::class,
            $rainGauge
        );
        $this->assertEquals("02:00:00:2c:00:01", $rainGauge->getId());

        $battery = $rainGauge->getBattery();
        $this->assertEquals(5590, $battery->getLevel());
        $this->assertEquals(95, $battery->getPercentage());

        $radio = $rainGauge->getRadio();
        $this->assertEquals(9, $radio->getSignalQuality());
        $this->assertEquals(15000, $radio->getLastSeen());
        $this->assertEquals(15000, $radio->getLastMessage());

        $measures = $rainGauge->getMeasures();
        $this->assertInstanceOf(
            Models\Weather\Measures::class,
            $measures
        );
        $this->assertEquals(15000, $measures->getTimestamp());
        $this->assertEquals(20, $measures->getWindStrength());
        $this->assertEquals(45, $measures->getWindAngle());
        $this->assertEquals(40, $measures->getGustStrength());
        $this->assertEquals(90, $measures->getGustAngle());

        // Check rain gauge
        $rainGauge = $modules[2];
        $this->assertInstanceOf(
            Models\Weather\RainGauge::class,
            $rainGauge
        );
        $this->assertEquals("02:00:00:2c:00:02", $rainGauge->getId());

        $battery = $rainGauge->getBattery();
        $this->assertEquals(5590, $battery->getLevel());
        $this->assertEquals(95, $battery->getPercentage());

        $radio = $rainGauge->getRadio();
        $this->assertEquals(9, $radio->getSignalQuality());
        $this->assertEquals(15000, $radio->getLastSeen());
        $this->assertEquals(15000, $radio->getLastMessage());

        $measures = $rainGauge->getMeasures();
        $this->assertInstanceOf(
            Models\Weather\Measures::class,
            $measures
        );
        $this->assertEquals(15000, $measures->getTimestamp());
        $this->assertEquals(500, $measures->getLastHourRain());
        $this->assertEquals(1000, $measures->getLastDayRain());
    }
}
