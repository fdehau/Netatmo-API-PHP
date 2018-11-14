<?php

namespace Netatmo\Sdk\Tests\Requests\AirCare;

use Netatmo\Sdk\Client;
use Netatmo\Sdk\Requests;
use Netatmo\Sdk\Responses;
use Netatmo\Sdk\Models;
use Netatmo\Sdk\Tests\Fixtures;
use Netatmo\Sdk\Tests\TestCase;

class HomeCoachsTest extends TestCase
{
    public function testGetHomeCoachs()
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
                            "name" => "Indoor",
                            "date_setup" => 1200,
                            "last_setup" => 1800,
                            "firmware" => 100,
                            "last_upgrade" => 2000,
                            "data_type" => [
                                "Temperature",
                                "Humidity"
                            ],
                            "dashboard_data" => [
                                "time_utc" => 15000,
                                "Temperature" => 23,
                                "Humidity" => 42,
                                "max_temp" => 33,
                                "date_max_temp" => 8000,
                                "min_temp" => 23,
                                "date_min_temp" => 7000,
                                "CO2" => 1000,
                                "Noise" => 53,
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
                        ]
                    ]
                ]
            )
        ]);

        $request = Requests\AirCare\HomeCoachs::getDevice("70:ee:50:2c:70:ca");
        $response = $client->send($request);

        // check request
        $this->assertRequest(
            [
                "uri" => [
                    "path" => "/api/gethomecoachsdata"
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
        $this->assertInstanceOf(
            Responses\Response::class,
            $response
        );
    }
}
