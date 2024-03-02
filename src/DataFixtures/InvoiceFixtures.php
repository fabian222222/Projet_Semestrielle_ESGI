<?php

namespace App\DataFixtures;

use App\Entity\Invoice;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Client;
use DateTime;

class InvoiceFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        $clients = $manager->getRepository(Client::class)->findAll();
        $numberClients = count($clients);

        for ($i = 0; $i < 10; $i++) {
            $client = $clients[$faker->numberBetween(0, $numberClients - 1)];

            $invoice = new Invoice();
            $invoice->setName($faker->name());
            $invoice->setDescription($faker->text());
            $invoice->setDate(new DateTime());
            $invoice->setTypePayment($faker->text($faker->numberBetween(6, 10)));
            $invoice->setPrice($faker->randomNumber(4));
            $invoice->setClient($client);
            $invoice->setDrivingSchool($client->getDrivingSchool());
            
            $manager->persist($invoice);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ClientFixtures::class,
        ];
    }
}
