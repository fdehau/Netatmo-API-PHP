<?php

namespace Netatmo\Sdk\Tests\Requests\Weather;

use Netatmo\Sdk\Client;
use Netatmo\Sdk\Requests;
use Netatmo\Sdk\Responses;
use Netatmo\Sdk\Models;
use Netatmo\Sdk\Tests\Fixtures;
use Netatmo\Sdk\Tests\TestCase;

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
                                "Pressure" => 1026.4,
                                "Noise" => 53,
                            ]
                        ]
                    ]
                ]
            )
        ]);

        $request = Requests\Weather\Stations::getDevice("70:ee:50:2c:70:ca");
        $response = $client->send($request);

        // check request
        $this->assertRequest(
            [
                "uri" => [
                    "path" => "/api/getstationsdata"
                ],
                "params" => [
                    "device_id" => "70:ee:50:2c:70:ca",
                ],
                "method" => "GET",
                "headers" => [
                    "authorization" => "Bearer {$client->getAccessToken()}"
                ]
            ],
            $client->getHttpClient()->getRequests()[0]
        );

        // check response
        $this->assertTrue(is_array($response));
    }

    public function testGetWeatherStationsWithFavorites()
    {
        $client = Fixtures\Client::withResponses([
            new Fixtures\Responses\Ok([])
        ]);

        $request = Requests\Weather\Stations::getDevice("70:ee:50:2c:70:ca")
            ->includeFavorites(true);
        $response = $client->send($request);

        // check request
        $this->assertRequest(
            [
                "uri" => [
                    "path" => "/api/getstationsdata"
                ],
                "params" => [
                    "device_id" => "70:ee:50:2c:70:ca",
                    "get_favorites" => "true"
                ],
                "method" => "GET",
                "headers" => [
                    "authorization" => "Bearer {$client->getAccessToken()}"
                ]
            ],
            $client->getHttpClient()->getRequests()[0]
        );

        // check response
        $this->assertTrue(is_array($response));
    }
}
