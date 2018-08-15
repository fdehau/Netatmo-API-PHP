<?php

namespace Netatmo\Tests\Requests;

use Netatmo\Client;
use Netatmo\Requests;
use Netatmo\Responses;
use Netatmo\Tests\Fixtures;
use PHPUnit\Framework\TestCase;

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

        $request = Requests\Measures::ofDevice("70:ee:50:2c:70:ca")
            ->withTypes(["Temperature", "humidity"])
            ->every("1hour");
        $response = $client->send($request);
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

        $request = Requests\Measures::ofDevice("70:ee:50:2c:70:ca")
            ->withTypes(["Temperature", "humidity"])
            ->every("1hour")
            ->withoutOptimization();
        $response = $client->send($request);
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
