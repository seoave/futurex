<?php
declare(strict_types=1);

namespace App\Controller\Order;

use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class CloseOrderController extends AbstractController
{
    public function __construct(
        private readonly OrderService $orderService
    ) {
    }

    #[Route('/order/close/{id}', name: 'app_order_close')]
    public function index(int $id): RedirectResponse
    {
        $this->orderService->close($id);

        return $this->redirectToRoute('trade');
    }
}
