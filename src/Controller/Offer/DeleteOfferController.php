<?php

declare(strict_types=1);

namespace App\Controller\Offer;

use App\Service\OfferService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class DeleteOfferController extends AbstractController
{
    public function __construct(
        private readonly OfferService $service
    ) {
    }

    #[Route('/order/delete/{id}', name: 'app_order_delete')]
    public function delete(int $id): RedirectResponse
    {
        $this->service->delete($id);

        return $this->redirectToRoute('trade');
    }
}
