<?php

declare(strict_types=1);

namespace App\Controller\Order;

use App\Repository\OfferRepository;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DeleteOrderController extends AbstractController
{
    public function __construct(
        private readonly OfferRepository $offerRepository
    ) {
    }

    #[Route('/order/delete/{id}', name: 'app_order_delete')]
    public function delete(int $id): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $offer = $this->offerRepository->find($id);

        if ($offer === null) {
            throw new EntityNotFoundException('Offer not found');
        }

        if ($offer->getOrderType() === 'draft') {
            $this->offerRepository->remove($offer, true);
        }

        return $this->redirectToRoute('trade');
    }
}
