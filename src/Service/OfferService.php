<?php
declare(strict_types=1);

namespace App\Service;

use App\Repository\OfferRepository;

class OfferService
{
    public function __construct(
        private readonly OfferRepository $offerRepository
    ) {
    }

    public function open(int $id): void
    {
        $offer = $this->offerRepository->find($id);

        if ($offer === null) {
            return;
        }

        if ($offer->getOrderType() === 'draft') {
            $offer->setOrderType('open');
            $this->offerRepository->save($offer, true);
        }
    }

    public function close(int $id): void
    {
        $offer = $this->offerRepository->find($id);

        if ($offer === null) {
            return;
        }

        $amount = $offer->getAmount();
        $stock = $offer->getStock();
        $type = '';

        if ($stock === $amount) {
            $type = 'draft';
        }

        if ($stock === 0) {
            $type = 'close';
        }

        if ($stock > 0 && $stock < $amount) {
            $type = 'part-closed';
        }

        $offer->setOrderType($type);
        $this->offerRepository->save($offer, true);
    }

    public function delete(int $id): void
    {
        $offer = $this->offerRepository->find($id);

        if ($offer === null) {
            return;
        }

        if ($offer->getOrderType() === 'draft') {
            $this->offerRepository->remove($offer, true);
        }
    }
}
