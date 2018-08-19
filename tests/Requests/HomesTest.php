<?php

namespace Netatmo\Sdk\Tests\Requests;

use Netatmo\Sdk\Client;
use Netatmo\Sdk\Requests;
use Netatmo\Sdk\Responses;
use Netatmo\Sdk\Models;
use Netatmo\Sdk\Tests\Fixtures;
use PHPUnit\Framework\TestCase;

class HomesTest extends TestCase
{
    public function testGetHome()
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
                    "homes" => [
                        [
                            "id" => "1234",
                            "name" => "My house",
                            "country" => "FR",
                            "altitude" => 84,
                            "timezone" => "Europe/Paris",
                            "coordinates" => [
                                2.23,
                                48.88
                            ]
                        ]
                    ]
                ]
            )
        ]);
        $request = Requests\Homes::getHome("1234")
            ->withGatewayTypes(["NAPlug"]);
        $response = $client->send($request);
        $this->assertInstanceOf(
            Responses\Homes::class,
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

        // Check homes
        $homes = $response->getHomes();
        $this->assertCount(1, $homes);
        $home = $homes[0];
        $this->assertInstanceOf(Models\Home::class, $home);
        $this->assertEquals("1234", $home->getId());
        $this->assertEquals("My house", $home->getName());
        $place = $home->getPlace();
        $this->assertInstanceOf(Models\Place::class, $place);
        $this->assertEquals("FR", $place->getCountry());
        $this->assertEquals("Europe/Paris", $place->getTimezone());
        $this->assertEquals(2.23, $place->getLongitude());
        $this->assertEquals(48.88, $place->getLatitude());
        $this->assertEquals(84, $place->getAltitude());
    }
}
