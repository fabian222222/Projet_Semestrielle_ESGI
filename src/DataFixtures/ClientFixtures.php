<?php

namespace App\DataFixtures;

use App\Entity\DrivingSchool;
use App\Entity\Invoice;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Client;
use DateTime;

class ClientFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        $drivingSchools = $manager->getRepository(DrivingSchool::class)->findAll();
        $numberDrivingSchools = count($drivingSchools);

        for ($i = 0; $i < 10; $i++) {
            $client = new Client();

            $client->setFirstname($faker->firstName());
            $client->setLastname($faker->lastName());
            $client->setEmail($faker->email());
            $client->setAddress($faker->address());
            $client->setCity($faker->city());
            $client->setZipCode($faker->randomNumber(5));
            $client->setNumber($faker->randomNumber(2));
            $client->setPhoneNumber($faker->phoneNumber());
            $client->setDrivingSchool($drivingSchools[$faker->numberBetween(0, $numberDrivingSchools - 1)]);

            $manager->persist($client);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            DrivingSchoolFixtures::class,
        ];
    }
}
