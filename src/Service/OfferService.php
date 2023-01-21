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

    public function open(int $id, int $userId): string
    {
        $offer = $this->offerRepository->find($id);
        $openOffer = $this->offerRepository->findOneByOpen($userId);

        if ($offer === null) {
            return 'Offer does not exist';
        }

        if ($openOffer !== null) {
            return 'You can have only 1 open offer in time. Close other offer to open another one';
        }

        if ($offer->getStatus() === 'draft') {
            $offer->setStatus('open');
            $this->offerRepository->save($offer, true);
        }

        return 'Order have been opened';
    }

    public function close(int $id): void
    {
        $offer = $this->offerRepository->find($id);

        if ($offer === null) {
            return;
        }

        $amount = $offer->getAmount();
        $stock = $offer->getStock();

        $type = $this->statusSelector($amount, $stock);

        $offer->setStatus($type);
        $this->offerRepository->save($offer, true);
    }

    public function delete(int $id): void
    {
        $offer = $this->offerRepository->find($id);

        if ($offer === null) {
            return;
        }

        if ($offer->getStatus() === 'draft') {
            $this->offerRepository->remove($offer, true);
        }
    }

    public function statusSelector(?float $amount, ?float $stock): string
    {
        $type = '';

        if ($stock === $amount) {
            $type = 'draft';
        }

        if ((int) $stock === 0) {
            $type = 'closed';
        }

        if ($stock > 0 && $stock < $amount) {
            $type = 'part-closed';
        }

        return $type;
    }
}
