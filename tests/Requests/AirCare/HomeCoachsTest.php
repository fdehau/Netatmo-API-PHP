<?php

namespace Netatmo\Sdk\Tests\Requests\AirCare;

use Netatmo\Sdk\Client;
use Netatmo\Sdk\Requests;
use Netatmo\Sdk\Responses;
use Netatmo\Sdk\Models;
use Netatmo\Sdk\Tests\Fixtures;
use PHPUnit\Framework\TestCase;

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
                            "station_name" => "Indoor",
                            "date_setup" => 1200,
                            "last_setup" => 1800,
                            "firmware" => 100,
                            "last_upgrade" => 2000,
                            "data_type" => [
                                "Temperature",
                                "Humidity"
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

        $station = $homeCoachs[0];
        $this->assertEquals("70:ee:50:2c:70:ca", $station->getId());
        $this->assertEquals(3600, $station->getLastStatusTimestamp());
        $this->assertEquals("Indoor", $station->getName());

        $installation = $station->getInstallation();
        $this->assertNotNull($installation);
        $this->assertEquals(1200, $installation->getFirstSetup());
        $this->assertEquals(1800, $installation->getLastSetup());

        $firmware = $station->getFirmware();
        $this->assertNotNull($firmware);
        $this->assertEquals(100, $firmware->getVersion());
        $this->assertEquals(2000, $firmware->getLastUpdate());

        $this->assertEquals(70, $station->getWifiSignalQuality());
        $this->assertEquals(
            ["Temperature", "Humidity"],
            $station->getMeasureTypes()
        );

        // Check place
        $place = $station->getPlace();
        $this->assertEquals(2.23, $place->getLongitude());
        $this->assertEquals(48.88, $place->getLatitude());
        $this->assertEquals(20, $place->getAltitude());
        $this->assertEquals("FR", $place->getCountry());
        $this->assertEquals("Paris", $place->getCity());
        $this->assertEquals("Europe/Paris", $place->getTimezone());
    }
}
