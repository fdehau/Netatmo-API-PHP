<?php

namespace Netatmo\Sdk\Tests\Requests\Energy;

use Netatmo\Sdk\Client;
use Netatmo\Sdk\Requests;
use Netatmo\Sdk\Responses;
use Netatmo\Sdk\Models;
use Netatmo\Sdk\Tests\Fixtures;
use Netatmo\Sdk\Http;
use Netatmo\Sdk\Parameters;
use Netatmo\Sdk\Tests\TestCase;

class RoomMeasuresTest extends TestCase
{
    public function testSetModeSchedule()
    {
        $client = Fixtures\Client::withResponses([
            new Fixtures\Responses\Ok(
                [
                    [
                        "beg_time" => 3600,
                        "step_time" => 3600,
                        "value" => [
                            [
                                10,
                            ],
                            [
                                11,
                            ],
                        ]
                    ],
                    [
                        "beg_time" => 14400,
                        "step_time" => 3600,
                        "value" => [
                            [
                                12,
                            ]
                        ]
                    ]
                ]
            )
        ]);
        $room = new Parameters\Room("1234", "2345");
        $measures = new Parameters\Measures(["Temperature"], "5min");
        $measures->setEnd(3600);
        $request = new Requests\Energy\RoomMeasures($room, $measures);
        $response = $client->send($request);

        // Check request
        $this->assertRequest(
            [
                "uri" => [
                    "path" => "/api/getroommeasure"
                ],
                "params" => [
                    "room_id" => "1234",
                    "home_id" => "2345",
                    "type" => "Temperature",
                    "scale" => "5min",
                    "end" => 3600,
                    "optimize" => true,
                    "real_time" => false
                ],
                "method" => "POST",
                "headers" => [
                    "authorization" => "Bearer {$client->getAccessToken()}"
                ]
            ],
            $client->getHttpClient()->getRequests()[0]
        );

        // Check response
        $this->assertTrue($response instanceof Responses\Measures);
        $this->assertEquals(
            [
                3600 => 10,
                7200 => 11,
                14400 => 12
            ],
            $response->get('Temperature')
        );
    }
}
