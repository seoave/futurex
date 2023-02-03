<?php

namespace App\DataFixtures;

use App\Entity\Currency;
use App\Entity\User;
use App\Factory\UserFactory;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //  UserFactory::createMany(10);

        $currency = new Currency();
        $currency->setCode('BTC');
        $currency->setName('bitcoin');
        $currency->setToken(true);

        $manager->persist($currency);
        $manager->flush();
    }
}
