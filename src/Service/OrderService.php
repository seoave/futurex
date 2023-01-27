<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Offer;
use App\Entity\Order;

class OrderService
{
    public static function createOrder(Offer $actualOffer, Offer $matchOffer): Order
    {
        $order = new Order();
        $order->setPayerOffer($actualOffer);
        $order->setRecipientOffer($matchOffer);
        $amount = 0;
        $order->setAmount($amount);

        return $order;
    }
}
