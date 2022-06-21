<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class User extends Fixture
{

    private Faker\Generator $faker;

    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    )
    {
        $this->faker = Faker\Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i < 10; $i++) {
            $user = new \App\Entity\User();

            $password = $this->passwordHasher->hashPassword($user, "password");

            $user->setEmail($this->faker->email)
                ->setPassword($password);
            $manager->persist($user);
            $this->addReference("user_$i", $user);
        }

        $manager->flush();
    }
}
