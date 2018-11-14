<?php

namespace Netatmo\Sdk\Tests\Requests;

use Netatmo\Sdk\Client;
use Netatmo\Sdk\Requests;
use Netatmo\Sdk\Responses;
use Netatmo\Sdk\Models;
use Netatmo\Sdk\Tests\Fixtures;
use Netatmo\Sdk\Tests\TestCase;

class CreateScheduleTest extends TestCase
{
    public function testCreateSchedule()
    {
        $client = Fixtures\Client::withResponses([
            new Fixtures\Responses\Ok([]),
        ]);
        $schedule = new Models\Schedules\EnergySchedule("2345", "1234");
        $schedule->setName("My schedule");
        $schedule->setFrostguardTemperature(7);
        $schedule->setAwayTemperature(12);
        $schedule->addEntry(new Models\Schedules\Entry(60, 1));
        $schedule->addEntry(new Models\Schedules\Entry(120, 2));
        $zone = new Models\Schedules\Zone(1, 0);
        $zone->setName("My first zone");
        $room = new Models\Schedules\EnergyRoom("2255031728");
        $room->setTemperature(15);
        $zone->addRoom($room);
        $room = new Models\Schedules\EnergyRoom("2539094912");
        $room->setTemperature(17);
        $zone->addRoom($room);
        $schedule->addZone($zone);
        $request = new Requests\CreateSchedule($schedule);
        $response = $client->send($request);

        // Check request
        $this->assertRequest(
            [
                "uri" => [
                    "path" => "/api/createnewhomeschedule"
                ],
                "params" => [
                    "home_id" => "1234",
                    "schedule_id" => "2345",
                    "name" => "My schedule",
                    "type" => "therm",
                    "away_temp" => 12,
                    "hg_temp" => 7,
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
                    ]
                ],
                "method" => "POST",
                "headers" => [
                    "authorization" => "Bearer {$client->getAccessToken()}"
                ]
            ],
            $client->getHttpClient()->getRequests()[0]
        );

        // Check response
        $this->assertInstanceOf(
            Responses\Response::class,
            $response
        );
    }
}
