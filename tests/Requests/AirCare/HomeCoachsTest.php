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
            Responses\AirCare\HomeCoachs::class,
            $response
        );

        // Check user
        $user = $response->getUser();
        $this->assertEquals("florian@netatmo.com", $user->getEmail());
        $administrative = $user->getAdministrative();
        $this->assertEquals("fr-FR", $administrative->getLang());
        $this->assertEquals("fr-FR", $administrative->getLocale());
        $this->assertEquals("FR", $administrative->getCountry());
        $this->assertEquals(1, $administrative->getUnit());
        $this->assertEquals(1, $administrative->getWindUnit());
        $this->assertEquals(1, $administrative->getPressureUnit());

        $homeCoachs = $response->getHomeCoachs();
        $this->assertCount(1, $homeCoachs);

        $homeCoach = $homeCoachs[0];
        $this->assertEquals("70:ee:50:2c:70:ca", $homeCoach->getId());
        $this->assertEquals(3600, $homeCoach->getLastStatusTimestamp());
        $this->assertEquals("Indoor", $homeCoach->getName());

        $installation = $homeCoach->getInstallation();
        $this->assertNotNull($installation);
        $this->assertEquals(1200, $installation->getFirstSetup());
        $this->assertEquals(1800, $installation->getLastSetup());

        $firmware = $homeCoach->getFirmware();
        $this->assertNotNull($firmware);
        $this->assertEquals(100, $firmware->getVersion());
        $this->assertEquals(2000, $firmware->getLastUpdate());

        $this->assertEquals(70, $homeCoach->getWifiSignalQuality());
        $this->assertEquals(
            ["Temperature", "Humidity"],
            $homeCoach->getMeasureTypes()
        );

        // Check place
        $place = $homeCoach->getPlace();
        $this->assertEquals(2.23, $place->getLongitude());
        $this->assertEquals(48.88, $place->getLatitude());
        $this->assertEquals(20, $place->getAltitude());
        $this->assertEquals("FR", $place->getCountry());
        $this->assertEquals("Paris", $place->getCity());
        $this->assertEquals("Europe/Paris", $place->getTimezone());

        // Check measures
        $measures = $homeCoach->getMeasures();
        $this->assertInstanceOf(
            Models\AirCare\Measures::class,
            $measures
        );
        $this->assertEquals(15000, $measures->getTimestamp());
        $this->assertEquals(23, $measures->getTemperature());
        $this->assertEquals(42, $measures->getHumidity());
        $this->assertEquals(33, $measures->getMaxTemperature()->getValue());
        $this->assertEquals(8000, $measures->getMaxTemperature()->getTimestamp());
        $this->assertEquals(23, $measures->getMinTemperature()->getValue());
        $this->assertEquals(7000, $measures->getMinTemperature()->getTimestamp());
        $this->assertEquals(1000, $measures->getCo2());
        $this->assertEquals(53, $measures->getNoise());
    }
}
