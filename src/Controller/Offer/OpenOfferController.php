<?php

declare(strict_types=1);

namespace App\Controller\Offer;

use App\Service\OfferService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class OpenOfferController extends AbstractController
{
    public function __construct(
        private readonly OfferService $service
    ) {
    }

    #[Route('/order/open/{id}', name: 'app_order_open')]
    public function open(int $id): RedirectResponse
    {
        $userId = 9; // TODO get current user id from session
        $message = $this->service->open($id, $userId);

        return $this->redirectToRoute('trade', [
            'message' => $message,
        ]);
    }
}
