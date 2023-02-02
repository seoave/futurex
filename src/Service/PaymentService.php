<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Order;
use App\Repository\WalletRepository;

class PaymentService
{
    public function __construct(
        private readonly WalletRepository $walletRepository,
        private readonly WalletService $walletService,
    ) {
    }

    public function orderTransfer(Order $order): bool
    {
        $offer = $order->getInitialOffer();
        if ($offer === null || $order->getMatchOffer() === null) {
            return false;
        }

        $type = $offer->getOfferType();
        $initialUser = $offer->getUser();
        $recepientUser = $order->getMatchOffer()->getUser();
        $token = $offer->getCurrency();
        $money = $offer->getExchangedCurrency();
        $tokensToTransfer = $order->getAmount();
        $moneyToTransfer = $order->getTotal();

        $wallets = [];
        $tokenOptions = [
            'currency' => $token,
            'items' => $tokensToTransfer,
        ];
        $moneyOptions = [
            'currency' => $money,
            'items' => $moneyToTransfer,
        ];

        if ($type === 'buy') {
            $wallets['debitTokenWallet'] = $this->walletService->debit($recepientUser, $tokenOptions);
            $wallets['creditTokenWallet'] = $this->walletService->credit($initialUser, $tokenOptions);

            $wallets['debitMoneyWallet'] = $this->walletService->debit($initialUser, $moneyOptions);
            $wallets['creditMoneyWallet'] = $this->walletService->credit($recepientUser, $moneyOptions);
        }

        if ($type === 'sell') {
            $wallets['debitTokenWallet'] = $this->walletService->debit($initialUser, $tokenOptions);
            $wallets['creditTokenWallet'] = $this->walletService->credit($recepientUser, $tokenOptions);

            $wallets['debitMoneyWallet'] = $this->walletService->debit($recepientUser, $moneyOptions);
            $wallets['creditMoneyWallet'] = $this->walletService->credit($initialUser, $moneyOptions);
        }

        $this->walletRepository->saveMany($wallets);

        return true;
    }
}
