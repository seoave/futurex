<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Offer;
use App\Entity\Order;
use App\Repository\WalletRepository;

class OrderService
{
    public function __construct(
        private readonly WalletRepository $walletRepository
    ) {
    }

    public function createOrder(Offer $actualOffer, Offer $matchOffer): Order
    {
        $order = new Order();
        $order->setInitialOffer($actualOffer);
        $order->setMatchOffer($matchOffer);

        $amount = min($matchOffer->getAmount(), $actualOffer->getAmount());
        $order->setAmount($amount);

        $rate = min($actualOffer->getRate(), $matchOffer->getRate());
        $order->setRate($rate);

        $total = $amount * $rate;
        $order->setTotal($total);

        return $order;
    }

    public function isFundsValid(Order $order): array
    {
        $message = '';
        $isEnough = true;

        $matchUser = $order->getMatchOffer()?->getUser();
        $actualUser = $order->getInitialOffer()?->getUser();
        $currency = $order->getInitialOffer()?->getExchangedCurrency();

        $orderTokens = $order->getAmount();
        $orderMoney = $order->getTotal();

        $walletTokens = $this->walletRepository->findWalletByCurrency($matchUser, $currency)
            ?->getAmount();// Matched User Wallet

        $walletMoney = $this->walletRepository->findWalletByCurrency($actualUser, $currency)
            ?->getAmount(); // Actual User Wallet

        if ($walletMoney < $orderMoney) {
            $message = 'No money';
            $isEnough = false;
        }

        if ($walletTokens < $orderTokens) {
            $message = 'No tokens';
            $isEnough = false;
        }

        return ['isEnough' => $isEnough, 'message' => $message];
    }
}
