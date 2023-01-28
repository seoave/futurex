<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Offer;
use App\Entity\Order;

class OrderService
{
    public function createOrder(Offer $actualOffer, Offer $matchOffer): Order
    {
        $order = new Order();
        $order->setInitialOffer($actualOffer);
        $order->setMatchOffer($matchOffer);

        $amount = min($matchOffer->getAmount(), $actualOffer->getAmount());
        $order->setAmount($amount);

        $total = $amount * $actualOffer->getRate();
        $order->setTotal($total);

        return $order;
    }
}
