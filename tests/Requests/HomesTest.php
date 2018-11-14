<?php

namespace Netatmo\Sdk\Tests\Requests;

use Netatmo\Sdk\Client;
use Netatmo\Sdk\Requests;
use Netatmo\Sdk\Responses;
use Netatmo\Sdk\Models;
use Netatmo\Sdk\Tests\Fixtures;
use Netatmo\Sdk\Tests\TestCase;

class HomesTest extends TestCase
{
    public function testGetHome()
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
                    "homes" => [
                        [
                            "id" => "1234",
                            "name" => "My house",
                            "country" => "FR",
                            "altitude" => 84,
                            "timezone" => "Europe/Paris",
                            "coordinates" => [
                                2.23,
                                48.88
                            ],
                            "rooms" => [
                                [
                                    "id" => "2255031728",
                                    "name" => "Salon",
                                    "type" => "livingroom",
                                    "modules_ids" => [
                                        "04:00:00:23:f2:10",
                                    ]
                                ],
                                [
                                    "id" => "2539094912",
                                    "name" => "Chambre",
                                    "type" => "bedroom",
                                    "modules_ids" => [
                                        "09:00:00:00:0b:bd",
                                    ]
                                ]
                            ],
                            "modules" => [
                                [
                                    "id" => "70:ee:50:23:d7:a8",
                                    "type" => "NAPlug",
                                    "name" => "Relais",
                                    "setup_date" => 1513259804,
                                    "modules_bridged" => [
                                        "04:00:00:23:f2:10",
                                        "09:00:00:00:0b:bd",
                                    ]
                                ],
                                [
                                    "id" => "04:00:00:23:f2:10",
                                    "type" => "NATherm1",
                                    "name" => "Thermostat",
                                    "setup_date" => 1513259817,
                                    "room_id" => "2255031728",
                                    "bridge" => "70:ee:50:23:d7:a8",
                                ],
                                [
                                    "id" => "09:00:00:00:0b:bd",
                                    "type" => "NRV",
                                    "name" => "Vanne Salon",
                                    "setup_date" => 1513260804,
                                    "room_id" => "2539094912",
                                    "bridge" => "70:ee:50:23:d7:a8",
                                ]
                            ],
                            "schedules" => [
                                [
                                    "id" => "123",
                                    "name" => "My schedule",
                                    "type" => "therm",
                                    "default" => true,
                                    "hg_temp" => 7,
                                    "away_temp" => 12,
                                    "timetable" => [
                                        [
                                            "m_offset" => 60,
                                            "zone_id" => 1
                                        ],
                                        [
                                            "m_offset" => 120,
                                            "zone_id" => 2
                                        ]
                                    ],
                                    "zones" => [
                                        [
                                            "id" => 1,
                                            "type" => 0,
                                            "name" => "My first zone",
                                            "rooms" => [
                                                [
                                                    "id" => "2255031728",
                                                    "therm_setpoint_temperature" => 15
                                                ],
                                                [
                                                    "id" => "2539094912",
                                                    "therm_setpoint_temperature" => 17
                                                ]
                                            ]
                                        ],
                                        [
                                            "id" => 2,
                                            "type" => 1,
                                            "name" => "My second zone",
                                            "rooms" => [
                                                [
                                                    "id" => "2255031728",
                                                    "therm_setpoint_temperature" => 14
                                                ],
                                                [
                                                    "id" => "2539094912",
                                                    "therm_setpoint_temperature" => 16
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            "therm_mode" => "schedule",
                            "therm_mode_endtime" => 15000000,
                            "therm_setpoint_default_duration" => 3600
                        ]
                    ]
                ]
            )
        ]);
        $request = Requests\Homes::getHome("1234")
            ->withGatewayTypes(["NAPlug"]);
        $response = $client->send($request);

        // Check request
        $this->assertRequest(
            [
                "uri" => [
                    "path" => "/api/homesdata",
                ],
                "params" => [
                    "home_id" => "1234",
                    "gateway_types" => [
                        "NAPlug"
                    ]
                ],
                "method" => "GET",
                "headers" => [
                    "authorization" => "Bearer {$client->getAccessToken()}"
                ]
            ],
            $client->getHttpClient()->getRequests()[0]
        );

        // Check response
        $this->assertTrue(is_array($response));
    }
}
