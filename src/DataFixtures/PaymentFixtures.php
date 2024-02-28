<?php

namespace App\DataFixtures;

use App\Entity\Invoice;
use App\Entity\Payment;
use App\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PaymentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        $status = $manager->getRepository(Status::class)->findAll();
        $invoices = $manager->getRepository(Invoice::class)->findAll();
        $nbInvoice = count($invoices);

        for ($i = 0; $i < $nbInvoice-1; $i++) {
            $payment = new Payment();

            $payment->setName($faker->name());
            $payment->setDate($faker->dateTimeThisYear());
            $payment->setInvoice($invoices[$i]);
            $payment->setStatus($status[$faker->numberBetween(0, 1)]);

            $manager->persist($payment);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            InvoiceFixtures::class,
            StatusFixtures::class
        ];
    }
}