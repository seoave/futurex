<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Offer;
use App\Entity\User;

class DataTransformer
{
    public static function formToOffer(array $formData, User $user): ?Offer
    {
        if (empty($formData)) {
            return null;
        }

        $offer = new Offer();
        $offer->setUser($user);
        $offer->setCurrency($formData['currency']);
        $offer->setExchangedCurrency($formData['exchangedCurrency']);
        $offer->setAmount($formData['amount']);
        $offer->setRate($formData['rate']);
        $offer->setStock($formData['amount']);
        $offer->setOfferType($formData['offerType']);

        return $offer;
    }
}
