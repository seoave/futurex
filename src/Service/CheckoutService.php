<?php
declare(strict_types=1);

namespace App\Service;

class CheckoutService
{
    public function isValidOffers(array $offers): bool
    {
        $result = true;
        foreach ($offers as $offer) {
            if ($offer === null || $offer->getStatus() === 'closed') {
                $result = false;
            }
        }

        return $result;
    }
}
