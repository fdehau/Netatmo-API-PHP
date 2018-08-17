<?php

namespace Netatmo\Sdk\Tests\Requests;

use Netatmo\Sdk\Client;
use Netatmo\Sdk\Requests;
use Netatmo\Sdk\Responses;
use Netatmo\Sdk\Tests\Fixtures;
use PHPUnit\Framework\TestCase;

class WeatherStationsTest extends TestCase
{
    public function testGetWeatherStations()
    {
        $client = Fixtures\Client::withResponses([
            new Fixtures\Responses\Ok(
                [
                    "user" => [
                        "mail" => "florian@netatmo.com",
                        "administrative" => [
                            "lang" => "fr-FR"
                        ]
                    ],
                    "devices" => [
                        [
                            "_id" => "70:ee:50:2c:70:ca",
                            "last_status_store" => 3600,
                            "place" => [
                                "location" => [
                                    2.23,
                                    48.88
                                ]
                            ]
                        ]
                    ]
                ]
            )
        ]);

        $request = Requests\WeatherStations::getDevice("70:ee:50:2c:70:ca")
            ->includeFavorites();
        $response = $client->send($request);
        $this->assertTrue($response instanceof Responses\WeatherStations);

        // Check user
        $user = $response->getUser();
        $this->assertEquals("florian@netatmo.com", $user->getEmail());

        // Check stations
        $stations = $response->getStations();
        $this->assertCount(1, $stations);
        $station = $stations[0];
        $this->assertEquals("70:ee:50:2c:70:ca", $station->getId());
        $this->assertEquals(3600, $station->getLastStatusTimestamp());
        $place = $station->getPlace();
        $this->assertEquals(2.23, $place->getLongitude());
        $this->assertEquals(48.88, $place->getLatitude());
    }
}
