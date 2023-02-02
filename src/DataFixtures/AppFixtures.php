<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setName('Semen');
        $user->setEmail('semen@mail.com');
        $user->setGender(1);
        $user->setBornAt(DateTimeImmutable::createFromFormat('d-m-Y', '01-02-1983'));
        $user->setPassword('test');

        $manager->persist($user);
        $manager->flush();
    }
}
