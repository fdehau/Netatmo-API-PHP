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
                            ],
                            "rooms" => [
                                [
                                    "id" => "2255031728",
                                    "name" => "Salon",
                                    "type" => "livingroom",
                                    "modules_ids" => [
                                        "04:00:00:23:f2:10",
                                    ]
                                ],
                                [
                                    "id" => "2539094912",
                                    "name" => "Chambre",
                                    "type" => "bedroom",
                                    "modules_ids" => [
                                        "09:00:00:00:0b:bd",
                                    ]
                                ]
                            ],
                            "modules" => [
                                [
                                    "id" => "70:ee:50:23:d7:a8",
                                    "type" => "NAPlug",
                                    "name" => "Relais",
                                    "setup_date" => 1513259804,
                                    "modules_bridged" => [
                                        "04:00:00:23:f2:10",
                                        "09:00:00:00:0b:bd",
                                    ]
                                ],
                                [
                                    "id" => "04:00:00:23:f2:10",
                                    "type" => "NATherm1",
                                    "name" => "Thermostat",
                                    "setup_date" => 1513259817,
                                    "room_id" => "2255031728",
                                    "bridge" => "70:ee:50:23:d7:a8",
                                ],
                                [
                                    "id" => "09:00:00:00:0b:bd",
                                    "type" => "NRV",
                                    "name" => "Vanne Salon",
                                    "setup_date" => 1513260804,
                                    "room_id" => "2539094912",
                                    "bridge" => "70:ee:50:23:d7:a8",
                                ]
                            ],
                            "schedules" => [
                                [
                                    "id" => "123",
                                    "name" => "My schedule",
                                    "type" => "therm",
                                    "default" => true,
                                    "hg_temp" => 7,
                                    "away_temp" => 12,
                                    "timetable" => [
                                        [
                                            "m_offset" => 60,
                                            "zone_id" => 1
                                        ],
                                        [
                                            "m_offset" => 120,
                                            "zone_id" => 2
                                        ]
                                    ],
                                    "zones" => [
                                        [
                                            "id" => 1,
                                            "type" => 0,
                                            "name" => "My first zone",
                                            "rooms" => [
                                                [
                                                    "id" => "2255031728",
                                                    "therm_setpoint_temperature" => 15
                                                ],
                                                [
                                                    "id" => "2539094912",
                                                    "therm_setpoint_temperature" => 17
                                                ]
                                            ]
                                        ],
                                        [
                                            "id" => 2,
                                            "type" => 1,
                                            "name" => "My second zone",
                                            "rooms" => [
                                                [
                                                    "id" => "2255031728",
                                                    "therm_setpoint_temperature" => 14
                                                ],
                                                [
                                                    "id" => "2539094912",
                                                    "therm_setpoint_temperature" => 16
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
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

        $rooms = $home->getRooms();
        $this->assertCount(2, $rooms);
        $room = $rooms[0];
        $this->assertEquals("2255031728", $room->getId());
        $this->assertEquals("Salon", $room->getName());
        $this->assertEquals("livingroom", $room->getType());
        $this->assertEquals(
            ["04:00:00:23:f2:10"],
            $room->getModules()
        );
        $room = $rooms[1];
        $this->assertEquals("2539094912", $room->getId());
        $this->assertEquals("Chambre", $room->getName());
        $this->assertEquals("bedroom", $room->getType());
        $this->assertEquals(
            ["09:00:00:00:0b:bd"],
            $room->getModules()
        );

        $modules = $home->getModules();
        $this->assertCount(3, $modules);

        $gateway = $modules[0];
        $this->assertInstanceOf(Models\Energy\Relay::class, $gateway);
        $this->assertEquals("70:ee:50:23:d7:a8", $gateway->getId());
        $this->assertEquals("Relais", $gateway->getName());
        $this->assertEquals(1513259804, $gateway->getInstallation()->getLastSetup());
        $this->assertEquals(
            [
                "04:00:00:23:f2:10",
                "09:00:00:00:0b:bd",
            ],
            $gateway->getModules()
        );

        $thermostat = $modules[1];
        $this->assertInstanceOf(Models\Energy\Thermostat::class, $thermostat);
        $this->assertEquals("04:00:00:23:f2:10", $thermostat->getId());
        $this->assertEquals("Thermostat", $thermostat->getName());
        $this->assertEquals(1513259817, $thermostat->getInstallation()->getLastSetup());
        $this->assertEquals("70:ee:50:23:d7:a8", $thermostat->getBridge());

        $valve = $modules[2];
        $this->assertInstanceOf(Models\Energy\Valve::class, $valve);
        $this->assertEquals("09:00:00:00:0b:bd", $valve->getId());
        $this->assertEquals("Vanne Salon", $valve->getName());
        $this->assertEquals(1513260804, $valve->getInstallation()->getLastSetup());
        $this->assertEquals("70:ee:50:23:d7:a8", $valve->getBridge());

        $schedules = $home->getSchedules();
        $this->assertCount(1, $schedules);
        $schedule = $schedules[0];
        $this->assertInstanceOf(
            Models\Schedules\EnergySchedule::class,
            $schedule
        );
        $this->assertEquals("123", $schedule->getId());
        $this->assertEquals("My schedule", $schedule->getName());
        $this->assertTrue($schedule->isDefault());
        $this->assertEquals(12, $schedule->getAwayTemperature());
        $this->assertEquals(7, $schedule->getFrostguardTemperature());

        $timetable = $schedule->getTimetable();
        $this->assertCount(2, $timetable);
        $entry = $timetable[0];
        $this->assertInstanceOf(
            Models\Schedules\Entry::class,
            $entry
        );
        $this->assertEquals(60, $entry->getOffset());
        $this->assertEquals(1, $entry->getZone());
        $entry = $timetable[1];
        $this->assertInstanceOf(
            Models\Schedules\Entry::class,
            $entry
        );
        $this->assertEquals(120, $entry->getOffset());
        $this->assertEquals(2, $entry->getZone());

        $zones = $schedule->getZones();
        $this->assertCount(2, $zones);
        $zone = $zones[0];
        $this->assertInstanceOf(
            Models\Schedules\Zone::class,
            $zone
        );
        $this->assertEquals(1, $zone->getId());
        $this->assertEquals(0, $zone->getType());
        $this->assertEquals("My first zone", $zone->getName());
        $rooms = $zone->getRooms();
        $this->assertCount(2, $rooms);
        $room = $rooms[0];
        $this->assertInstanceOf(
            Models\Schedules\Room::class,
            $room
        );
        $this->assertEquals("2255031728", $room->getId());
        $this->assertEquals(15, $room->getTemperature());
        $room = $rooms[1];
        $this->assertInstanceOf(
            Models\Schedules\Room::class,
            $room
        );
        $this->assertEquals("2539094912", $room->getId());
        $this->assertEquals(17, $room->getTemperature());
        $zone = $zones[1];
        $this->assertInstanceOf(
            Models\Schedules\Zone::class,
            $zone
        );
        $this->assertEquals(2, $zone->getId());
        $this->assertEquals(1, $zone->getType());
        $this->assertEquals("My second zone", $zone->getName());
        $rooms = $zone->getRooms();
        $this->assertCount(2, $rooms);
        $room = $rooms[0];
        $this->assertInstanceOf(
            Models\Schedules\Room::class,
            $room
        );
        $this->assertEquals("2255031728", $room->getId());
        $this->assertEquals(14, $room->getTemperature());
        $room = $rooms[1];
        $this->assertInstanceOf(
            Models\Schedules\Room::class,
            $room
        );
        $this->assertEquals("2539094912", $room->getId());
        $this->assertEquals(16, $room->getTemperature());
    }
}