<?php
declare(strict_types=1);

namespace App\Controller\Order;

use App\Repository\OfferRepository;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CloseOrderController extends AbstractController
{
    public function __construct(
        private readonly OfferRepository $offerRepository
    ) {
    }

    #[Route('/order/close/{id}', name: 'app_order_close')]
    public function index(int $id)
    {
        $offer = $this->offerRepository->find($id);

        if ($offer === null) {
            throw new EntityNotFoundException('Offer not found');
        }

        if ($offer->getAmount() === $offer->getStock()) {
            $offer->setOrderType('draft');
            $this->offerRepository->save($offer, true);
        } else {
            $offer->setOrderType('close');
            $this->offerRepository->save($offer, true);
        }

        return $this->redirectToRoute('trade');
    }
}
