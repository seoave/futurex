<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Offer;
use App\Entity\Order;
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

        $type = $this->selectStatusByStock($amount, $stock);

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

    public function block(Offer $offer): void
    {
        if ($offer === null) {
            return;
        }

        $offer->setStatus('blocked');
        $this->offerRepository->save($offer, true);
    }

    public function unBlockDraft(?Offer $offer): void
    {
        if ($offer && $offer->getStatus() === 'blocked') {
            $this->unBlock($offer);
        }
    }

    public function unBlock(Offer $offer): void
    {
        if ($offer === null) {
            return;
        }

        $offer->setStatus('open');
        $this->offerRepository->save($offer, true);
    }

    public function selectStatusByStock(?float $amount, ?float $stock): string
    {
        $status = '';

        if ($stock === $amount) {
            $status = 'draft';
        }

        if ((int) $stock === 0) {
            $status = 'closed';
        }

        if ($stock > 0 && $stock < $amount) {
            $status = 'part-closed';
        }

        return $status;
    }

    public function updateOrderOffersStockAndStatus(Order $order): bool
    {
        $initOffer = $order->getInitialOffer();
        $orderAmount = $order->getAmount();
        $recipientOffer = $order->getMatchOffer();

        if ($initOffer === null || $recipientOffer === null) {
            return false;
        }

        $this->updateStockAndStatus($initOffer, $orderAmount);
        $this->updateStockAndStatus($recipientOffer, $orderAmount);

        return true;
    }

    public function updateStockAndStatus(Offer $offer, float $orderAmount)
    {
        $offerAmount = $offer->getAmount();
        $updatedStock = $offerAmount - $orderAmount;
        $offer->setStock($updatedStock);
        $updatedStatus = $this->selectStatusByStock($offerAmount, $offer->getStock());
        $offer->setStatus($updatedStatus);
        $this->offerRepository->save($offer);
    }
}
