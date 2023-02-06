<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Currency;
use App\Entity\User;
use App\Entity\Wallet;
use App\Repository\WalletRepository;
use App\Repository\CurrencyRepository;

class WalletService
{
    public function __construct(
        private readonly WalletRepository $repository,
        private readonly CurrencyRepository $currencyRepository
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

    public function credit(User $user, array $options): Wallet
    {
        $wallet = $this->getWallet($user, $options['currency']);

        if ($wallet === null) {
            $wallet = new Wallet($user, $options['currency']);
        }

        $updatedAmount = $wallet->getAmount() + $options['items'];

        return $wallet->setAmount($updatedAmount);
    }

    public function getTotalFundsByIsToken(bool $token = false): array
    {
        $currency = $this->currencyRepository->findBy([
            'token' => $token,
        ]);

        $wallets = $this->repository->findBy([
            'currency' => $currency,
        ]);

        $codes = static::getUniqueWalletCurrencyCodes($wallets);

        return static::getTotalFundsByCurrencyCodes($codes, $wallets);
    }

    public static function getUniqueWalletCurrencyCodes(array $wallets): array
    {
        $codes = [];

        foreach ($wallets as $wallet) {
            $codes[] = $wallet->getCurrency()->getCode();
        }

        return array_unique($codes);
    }

    public static function getTotalFundsByCurrencyCodes(array $codes, array $wallets): array
    {
        $result = [];

        foreach ($codes as $code => $value) {
            $result[$value] = 0;
            foreach ($wallets as $wallet) {
                if ($wallet->getCurrency()->getCode() === $value) {
                    $result[$value] = $result[$value] + $wallet->getAmount();
                }
            }
        }

        return $result;
    }
}
