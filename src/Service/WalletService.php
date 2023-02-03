<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Currency;
use App\Entity\User;
use App\Entity\Wallet;
use App\Repository\WalletRepository;

class WalletService
{
    public function __construct(
        private readonly WalletRepository $repository
    ) {
    }

    public function getWallet(User $user, Currency $currency): ?Wallet
    {
        return $this->repository->findOneBy([
            'owner' => $user,
            'currency' => $currency,
        ]);
    }

    public function debit(User $user, array $options): Wallet|false
    {
        $wallet = $this->getWallet($user, $options['currency']);

        if ($wallet === null) {
            return false;
        }

        $updatedAmount = $wallet->getAmount() - $options['items'];

        return $wallet->setAmount($updatedAmount);
    }

    public function credit(User $user, array $options)
    {
        $wallet = $this->getWallet($user, $options['currency']);

        if ($wallet === null) {
            $wallet = new Wallet($user, $options['currency']);
        }

        $updatedAmount = $wallet->getAmount() + $options['items'];

        return $wallet->setAmount($updatedAmount);
    }
}
