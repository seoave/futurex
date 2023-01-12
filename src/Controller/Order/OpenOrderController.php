<?php

declare(strict_types=1);

namespace App\Controller\Order;

use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class OpenOrderController extends AbstractController
{
    public function __construct(
        private readonly OrderService $orderService
    ) {
    }

    #[Route('/order/open/{id}', name: 'app_order_open')]
    public function open(int $id): RedirectResponse
    {
        $this->orderService->open($id);

        return $this->redirectToRoute('trade');
    }
}
