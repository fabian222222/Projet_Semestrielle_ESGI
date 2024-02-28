<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\DrivingSchool;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher) {}

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');
        $pwd = 'test';

        $users =  [
            [
                'email' => 'user@user.fr',
                'role' => ['ROLE_USER'],
                'name' => 'user',
                'reference' => 'user',
                'firstname' => 'user'
            ],
            [
                'email' => 'admin@user.fr',
                'role' => ['ROLE_ADMIN'],
                'name' => 'admin',
                'reference' => 'admin',
                'firstname' => 'admin'
            ],
            [
                'email' => 'boss@user.fr',
                'role' => ['ROLE_BOSS'],
                'name' => 'boss',
                'reference' => 'boss',
                'firstname' => 'boss'
            ],
        ];

        $drivingSchools = $manager->getRepository(DrivingSchool::class)->findAll();
        $numberDrivingSchools = count($drivingSchools);

        foreach ($users as $user) {
            $object = (new User())
                ->setEmail($user['email'])
                ->setRoles($user['role'])
                ->setLastname($user['name'])
                ->setFirstname($user['firstname'])
            ;
            $object->addDrivingSchool($drivingSchools[$faker->numberBetween(0, $numberDrivingSchools - 1)]);
            $object->setPassword($this->passwordHasher->hashPassword($object, $pwd));
            $manager->persist($object);
            $this->addReference($user['reference'], $object);
        }

        for ($i = 0; $i < 10; $i++) {
            $user = (new User())
                ->setEmail($faker->email)
                ->setRoles([])
                ->setLastname($faker->lastName())
                ->setFirstname($faker->firstName())
            ;
            $user->setPassword($this->passwordHasher->hashPassword($user, $pwd));
            $manager->persist($user);
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
