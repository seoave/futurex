<?php

namespace App\DataFixtures;

use App\Entity\Currency;
use App\Entity\User;
use App\Entity\Wallet;
use App\Factory\UserFactory;
use App\Repository\CurrencyRepository;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly CurrencyRepository $currencyRepository
    ) {
    }

    public function load(ObjectManager $manager): void
    {
//        UserFactory::createOne(['email' => 'admin@admin.com']);
//        UserFactory::createMany(10);

//        $currency = new Currency();
//        $currency->setCode('BTC');
//        $currency->setName('bitcoin');
//        $currency->setToken(true);

        $user = $this->userRepository->find(18);
        $currency = $this->currencyRepository->find(4);

        $wallet = new Wallet($user, $currency);

        $manager->persist($wallet);
        $manager->flush();
    }
}
