<?php

namespace Netatmo\Sdk\Tests\Requests;

use Netatmo\Sdk\Client;
use Netatmo\Sdk\Requests;
use Netatmo\Sdk\Responses;
use Netatmo\Sdk\Parameters;
use Netatmo\Sdk\Tests\Fixtures;
use Netatmo\Sdk\Tests\TestCase;

class MeasuresTest extends TestCase
{
    public function testGetOptimizedMeasures()
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
                                20
                            ],
                            [
                                11,
                                21
                            ],
                        ]
                    ],
                    [
                        "beg_time" => 14400,
                        "step_time" => 3600,
                        "value" => [
                            [
                                12,
                                22
                            ]
                        ]
                    ]
                ]
            )
        ]);

        $measures = new Parameters\Measures(["Temperature", "humidity"], "1hour");
        $request = Requests\Measures::ofDevice("70:ee:50:2c:70:ca", $measures);
        $response = $client->send($request);

        // check request
        $this->assertRequest(
            [
                "uri" => [
                    "path" => "/api/getmeasure"
                ],
                "params" => [
                    "device_id" => "70:ee:50:2c:70:ca",
                    "type" => "Temperature,humidity",
                    "scale" => "1hour",
                    "optimize" => "true",
                    "real_time" => "false"
                ],
                "method" => "GET",
                "headers" => [
                    "authorization" => "Bearer {$client->getAccessToken()}"
                ]
            ],
            $client->getHttpClient()->getRequests()[0]
        );

        // check response
        $this->assertTrue($response instanceof Responses\Measures);
        $this->assertEquals(
            [
                3600 => 10,
                7200 => 11,
                14400 => 12
            ],
            $response->get('Temperature')
        );
        $this->assertEquals(
            [
                3600 => 20,
                7200 => 21,
                14400 => 22
            ],
            $response->get('humidity')
        );
    }

    public function testGetMeasures()
    {
        $client = Fixtures\Client::withResponses([
            new Fixtures\Responses\Ok(
                [
                    3600 => [
                        10,
                        20,
                    ],
                    7200 => [
                        11,
                        21
                    ],
                    14400 => [
                        12,
                        22
                    ]
                ]
            )
        ]);

        $measures = new Parameters\Measures(["Temperature", "humidity"], "1hour");
        $measures->disableOptimization();
        $request = Requests\Measures::ofDevice("70:ee:50:2c:70:ca", $measures);
        $response = $client->send($request);

        // check request
        $this->assertRequest(
            [
                "params" => [
                    "device_id" => "70:ee:50:2c:70:ca",
                    "type" => "Temperature,humidity",
                    "scale" => "1hour",
                    "optimize" => "false",
                    "real_time" => "false"
                ],
                "method" => "GET",
                "headers" => [
                    "authorization" => "Bearer {$client->getAccessToken()}"
                ]
            ],
            $client->getHttpClient()->getRequests()[0]
        );

        // check response
        $this->assertTrue($response instanceof Responses\Measures);
        $this->assertEquals(
            [
                3600 => 10,
                7200 => 11,
                14400 => 12
            ],
            $response->get('Temperature')
        );
        $this->assertEquals(
            [
                3600 => 20,
                7200 => 21,
                14400 => 22
            ],
            $response->get('humidity')
        );
    }
}
