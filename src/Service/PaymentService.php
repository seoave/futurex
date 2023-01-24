<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Currency;
use App\Entity\Offer;
use App\Entity\User;
use App\Entity\Wallet;
use App\Repository\WalletRepository;
use Doctrine\ORM\EntityManagerInterface;

class PaymentService
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly WalletRepository $walletRepository,
    ) {
    }

    public function go(int $match, int $actual)
    {
        $offers = $this->getOffers($match, $actual);

        $matchTokenWallet = $this->getWallet($offers['match']->getUser(), $offers['match']->getCurrency());

        $actualTokenWallet = $this->getWallet($offers['actual']->getUser(), $offers['match']->getCurrency());

        if ($matchTokenWallet === null || $actualTokenWallet === null) {
            return $this->redirectToRoute('app_payment_checkout_index', [
                'message' => 'Wallet not found, sorry',
            ]);
        }

// TODO debit tokens from the account
        $matchTokenWalletAmount = $matchTokenWallet->getAmount();
        $matchTokenWallet->setAmount($matchTokenWalletAmount - $offers['match']->getAmount());

// TODO credit the tokens to the account
        $actualTokenWalletAmount = $actualTokenWallet->getAmount();
        $actualTokenWallet->setAmount($actualTokenWalletAmount + $offers['match']->getAmount());

// TODO debit money from the account
        $matchCurrencyWallet = $this->getWallet($offers['match']->getUser(), $offers['match']->getExchangedCurrency());
        $actualCurrencyWallet = $this->getWallet($offers['match']->getUser(), $offers['match']->getExchangedCurrency());

        if ($matchCurrencyWallet === null || $actualCurrencyWallet === null) {
            return $this->redirectToRoute('app_payment_checkout_index', [
                'message' => 'Currency Wallets not found, sorry',
            ]);
        }

        $actualCurrencyWalletAmount = $actualCurrencyWallet->getAmount();
// TODO set debit token amount, example taken
        $currencyDebit = $offers['match']->getAmount() * $offers['match']->getRate();
        $actualCurrencyWallet->setAmount($actualCurrencyWalletAmount - $currencyDebit);
        $currencyCredit = $matchCurrencyWallet->getAmount() + $currencyDebit;
        $matchCurrencyWallet->setAmount($currencyCredit);

        $wallets = [
            $matchTokenWallet,
            $actualTokenWallet,
            $actualCurrencyWallet,
            $matchCurrencyWallet,
        ];
        $this->walletRepository->saveMany($wallets);
    }

    private function getWallet(User $user, Currency $currencyId): ?Wallet
    {
        return $this->em->getRepository(Wallet::class)->findOneBy([
            'owner' => $user,
            'currency' => $currencyId,
        ]);
    }

    public function haveWalletsEnoughFunds(int $match, int $actual): array
    {
        $message = '';
        $isEnough = true;

        $offers = $this->getOffers($match, $actual);

        $matchAmount = $offers['match']->getAmount();
        $actualAmount = $offers['actual']->getAmount();
        $matchUser = $offers['match']->getUser();
        $actualUser = $offers['actual']->getUser();
        $currency = $offers['actual']->getCurrency();

        $orderTokens = $matchAmount >= $actualAmount ? $actualAmount : $matchAmount;
        $orderMoney = $orderTokens * $offers['actual']->getRate();

        $walletTokens = $this->walletRepository->findWalletByCurrency($matchUser, $currency)
            ->getAmount();// Matched User Wallet

        $walletMoney = $this->walletRepository->findWalletByCurrency($actualUser, $currency)
            ->getAmount(); // Actual User Wallet

        if ($walletMoney !== $orderMoney) {
            $message = 'No money';
            $isEnough = false;
        }

        if ($walletTokens !== $orderTokens) {
            $message = 'No tokens';
            $isEnough = false;
        }

        return ['isEnough' => $isEnough, 'message' => $message];
    }

    public function getOffers(int $match, int $actual): array
    {
        $matchOffer = $this->em->getRepository(Offer::class)->find($match);
        $actualOffer = $this->em->getRepository(Offer::class)->find($actual);

        return [
            'match' => $matchOffer,
            'actual' => $actualOffer,
        ];
    }
}
