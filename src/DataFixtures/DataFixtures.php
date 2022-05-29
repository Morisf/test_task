<?php

namespace App\DataFixtures;

use App\Entity\Equipment;
use App\Entity\LocationEquipment;
use App\Entity\Station;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DataFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $campers = $this->loadJson('campers');
        $equipments = $this->loadJson('equipment');
        $stations = $this->loadJson('stations');

        foreach ($stations as $station) {
            $location = new Station();
            $location->setCountryCode($station['country']);
            $location->setCity($station['city']);
            $manager->persist($location);
            foreach ($equipments as $equipment) {
                $item = new Equipment();
                $item->setTitle($equipment['title']);
                $item->setPrice($equipment['price']);
                $item->setOneTimePayment($equipment['oneTimePayment']);
                $locationEquipment = new LocationEquipment();
                $locationEquipment->setLocation($location);
                $locationEquipment->setEquipment($item);
                $locationEquipment->setQuantity(10);
                $manager->persist($item);
                $manager->persist($locationEquipment);
            }
        }

        $manager->flush();
    }

    /**
     * @throws \JsonException
     */
    private function loadJson(string $fileName)
    {
        return json_decode(
            file_get_contents(__DIR__ . "/json/{$fileName}.json"),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
    }
}
