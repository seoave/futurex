<?php

declare(strict_types=1);

namespace App\Controller\Order;

use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class DeleteOrderController extends AbstractController
{
    public function __construct(
        private readonly OrderService $orderService
    ) {
    }

    #[Route('/order/delete/{id}', name: 'app_order_delete')]
    public function delete(int $id): RedirectResponse
    {
        $this->orderService->delete($id);

        return $this->redirectToRoute('trade');
    }
}
