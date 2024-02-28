<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $product = new Product();

            $product->setProductName($faker->name());
            $product->setProductDescription($faker->paragraph());
            $product->setProductHour($faker->randomNumber(2));
            $product->setProductPrice($faker->randomNumber(4));

            $manager->persist($product);
        }

        $manager->flush();
    }
}