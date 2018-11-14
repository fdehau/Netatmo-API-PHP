<?php

namespace Netatmo\Sdk\Tests\Requests\Energy;

use Netatmo\Sdk\Client;
use Netatmo\Sdk\Requests;
use Netatmo\Sdk\Responses;
use Netatmo\Sdk\Models;
use Netatmo\Sdk\Tests\Fixtures;
use Netatmo\Sdk\Http;
use Netatmo\Sdk\Tests\TestCase;

class SetThermostatModeTest extends TestCase
{
    public function testSetModeSchedule()
    {
        $client = Fixtures\Client::withResponses([
            new Fixtures\Responses\Ok([]),
        ]);
        $request = new Requests\Energy\SetThermostatMode("1234", "schedule");
        $request->setEnd(3600);
        $response = $client->send($request);

        // Check request
        $this->assertRequest(
            [
                "uri" => [
                    "path" => "/api/setthermmode"
                ],
                "params" => [
                    "home_id" => "1234",
                    "mode" => "schedule",
                    "endtime" => 3600
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
