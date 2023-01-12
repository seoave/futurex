<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Offer;
use App\Repository\OfferRepository;
use Doctrine\ORM\EntityNotFoundException;

class OrderService
{
    public function __construct(
        private readonly OfferRepository $offerRepository
    ) {
    }

    public const ENTITYNOTFOUND = 'Offer not found';

    /**
     * @throws EntityNotFoundException
     */
    public function getOffer(int $id): Offer
    {
        $offer = $this->offerRepository->find($id);

        if ($offer === null) {
            throw new EntityNotFoundException(self::ENTITYNOTFOUND);
        }

        return $offer;
    }

    /**
     * @throws EntityNotFoundException
     */
    public function open(int $id): void
    {
        $offer = $this->getOffer($id);

        if ($offer->getOrderType() === 'draft') {
            $offer->setOrderType('open');
            $this->offerRepository->save($offer, true);
        }
    }

    /**
     * @throws EntityNotFoundException
     */
    public function close(int $id): void
    {
        $offer = $this->offerRepository->find($id);

        if ($offer === null) {
            throw new EntityNotFoundException(self::ENTITYNOTFOUND);
        }

        if ($offer->getAmount() === $offer->getStock()) {
            $offer->setOrderType('draft');
            $this->offerRepository->save($offer, true);
        } else {
            $offer->setOrderType('close');
            $this->offerRepository->save($offer, true);
        }
    }

    /**
     * @throws EntityNotFoundException
     */
    public function delete(int $id): void
    {
        $offer = $this->offerRepository->find($id);

        if ($offer === null) {
            throw new EntityNotFoundException(self::ENTITYNOTFOUND);
        }

        if ($offer->getOrderType() === 'draft') {
            $this->offerRepository->remove($offer, true);
        }
    }
}
