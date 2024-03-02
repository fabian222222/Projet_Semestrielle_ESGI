<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Contract;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ContractFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        $clients = $manager->getRepository(Client::class)->findAll();
        $numberClients = count($clients);

        for ($i = 0; $i < 10; $i++) {
            $client = $clients[$faker->numberBetween(0, $numberClients - 1)];

            $contrat = new Contract();
            $contrat->setName($faker->name());
            $contrat->setDrivingSchool($client->getDrivingSchool());
            $contrat->setPrice($faker->randomNumber(3));
            $contrat->setDescription($faker->paragraph);
            $contrat->setClient($client);
            $contrat->setValidityDate($faker->dateTimeBetween("-2 years", "+2 years"));

            $manager->persist($contrat);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ClientFixtures::class
        ];
    }
}