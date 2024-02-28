<?php

namespace App\DataFixtures;

use App\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StatusFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        $statusPaye = new Status();
        $statusEnCours = new Status();

        $statusPaye->setName('Payé');
        $statusEnCours->setName('En cours');

        $manager->persist($statusPaye);
        $manager->persist($statusEnCours);

        $manager->flush();
    }
}