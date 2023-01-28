<?php
declare(strict_types=1);

namespace App\Controller\Offer;

use App\Service\OfferService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class CloseOfferController extends AbstractController
{
    public function __construct(
        private readonly OfferService $service
    ) {
    }

    #[Route('/order/close/{id}', name: 'app_order_close')]
    public function index(int $id): RedirectResponse
    {
        $this->service->close($id);

        return $this->redirectToRoute('app_user_trade_view');
    }
}
