<?php

namespace Netatmo\Sdk\Tests\Requests\Energy;

use Netatmo\Sdk\Client;
use Netatmo\Sdk\Requests;
use Netatmo\Sdk\Responses;
use Netatmo\Sdk\Models;
use Netatmo\Sdk\Tests\Fixtures;
use Netatmo\Sdk\Tests\TestCase;

class SetRoomTemperatureTest extends TestCase
{
    public function testSetHomeMode()
    {
        $client = Fixtures\Client::withResponses([
            new Fixtures\Responses\Ok([]),
        ]);
        $request = Requests\Energy\SetRoomTemperature::withHomeMode("1234", "2345");
        $request->setEnd(3600);
        $response = $client->send($request);

        // check request
        $this->assertRequest(
            [
                "params" => [
                    "home_id" => "1234",
                    "room_id" => "2345",
                    "mode" => "home",
                    "endtime" => 3600
                ],
                "method" => "POST",
                "headers" => [
                    "authorization" => "Bearer {$client->getAccessToken()}"
                ]
            ],
            $client->getHttpClient()->getRequests()[0]
        );

        // check response
        $this->assertNull($response);
    }

    public function testSetTemperature()
    {
        $client = Fixtures\Client::withResponses([
            new Fixtures\Responses\Ok([]),
        ]);
        $request = Requests\Energy\SetRoomTemperature::withTemperature("1234", "2345", 24);
        $request->setEnd(3600);
        $response = $client->send($request);

        // check request
        $this->assertRequest(
            [
                "params" => [
                    "home_id" => "1234",
                    "room_id" => "2345",
                    "mode" => "manual",
                    "temp" => 24,
                    "endtime" => 3600
                ],
                "method" => "POST",
                "headers" => [
                    "authorization" => "Bearer {$client->getAccessToken()}"
                ]
            ],
            $client->getHttpClient()->getRequests()[0]
        );

        // check response
        $this->assertNull($response);
    }
}
