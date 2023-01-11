<?php

declare(strict_types=1);

namespace App\Controller\Order;

use App\Repository\OfferRepository;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class OpenOrderController extends AbstractController
{
    public function __construct(
        private readonly OfferRepository $offerRepository
    ) {
    }

    #[Route('/order/open/{id}', name: 'app_order_open')]
    public function open(int $id): RedirectResponse
    {
        $offer = $this->offerRepository->find($id);

        if ($offer === null) {
            throw new EntityNotFoundException('Offer not found');
        }

        if ($offer->getOrderType() === 'draft') {
            $offer->setOrderType('open');
            $this->offerRepository->save($offer, true);
        }

        return $this->redirectToRoute('trade');
    }
}
