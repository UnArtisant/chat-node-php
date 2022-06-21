<?php

namespace App\DataFixtures;

use App\Entity\Message;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class Conversation extends Fixture implements DependentFixtureInterface
{

    private Faker\Generator $faker;

    public function __construct()
    {
        $this->faker = Faker\Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {


        for ($i = 1; $i < 10; $i++) {
            /**
             * @var \App\Entity\User $user
             * @var \App\Entity\User $default_user
             */
            $default_user = $this->getReference("user_0");
            $user = $this->getReference("user_$i");

            $conversation = new \App\Entity\Conversation();

            $conversation->addUser($default_user)
                ->addUser($user);

            $this->generateMessages(4, $conversation, $default_user, $manager);
            $this->generateMessages(3, $conversation, $user, $manager);

            $manager->persist($conversation);
        }

        $manager->flush();
    }

    public function generateMessages(
        int $number,
        \App\Entity\Conversation $conversation,
        \App\Entity\User $user,
        ObjectManager $manager): void
    {
        for ($j = 0; $j < $number; $j++) {
            $message = new Message();
            $message->setOwner($user)
                ->setContent("message test")
                ->setConversation($conversation);

            $manager->persist($message);
        }
    }

    public function getDependencies() : array
    {
        return [
            User::class
        ];
    }
}
