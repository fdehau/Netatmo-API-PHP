<?php

namespace Netatmo\Sdk\Tests\Requests;

use Netatmo\Sdk\Client;
use Netatmo\Sdk\Requests;
use Netatmo\Sdk\Responses;
use Netatmo\Sdk\Models;
use Netatmo\Sdk\Tests\Fixtures;
use Netatmo\Sdk\Tests\TestCase;

class DeleteScheduleTest extends TestCase
{
    public function testDeleteSchedule()
    {
        $client = Fixtures\Client::withResponses([
            new Fixtures\Responses\Ok([]),
        ]);
        $schedule = new Models\Schedules\Schedule("2345", "1234");
        $schedule->setName("My schedule");
        $request = new Requests\DeleteSchedule($schedule);
        $response = $client->send($request);

        // Check request
        $this->assertRequest(
            [
                "uri" => [
                    "path" => "/api/deletehomeschedule"
                ],
                "params" => [
                    "home_id" => "1234",
                    "schedule_id" => "2345",
                ],
                "method" => "POST",
                "headers" => [
                    "authorization" => "Bearer {$client->getAccessToken()}"
                ]
            ],
            $client->getHttpClient()->getRequests()[0]
        );

        // Check response
        $this->assertNull($response);
    }
}
