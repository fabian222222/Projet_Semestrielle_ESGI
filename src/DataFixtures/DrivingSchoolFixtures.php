<?php

namespace App\DataFixtures;

use App\Entity\DrivingSchool;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DrivingSchoolFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $drivingSchool = new DrivingSchool();
            $drivingSchool->setName($faker->company());
            $drivingSchool->setAddress($faker->address());
            $drivingSchool->setNumber($faker->randomNumber(2));
            $drivingSchool->setCity($faker->city());
            $drivingSchool->setZipCode($faker->randomNumber(5));
            $drivingSchool->setSiret($faker->randomNumber(6));

            $manager->persist($drivingSchool);
        }

        $manager->flush();
    }
}