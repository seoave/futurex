<?php
declare(strict_types=1);

namespace App\Controller\Payment;

use App\Repository\OrderRepository;
use App\Service\PaymentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PaymentController extends AbstractController
{
    public function __construct(
        private OrderRepository $orderRepository
    ) {
    }

    #[Route('/order/pay/{id}', name: 'app_payment_order_view')]
    public function view(int $id, PaymentService $service): RedirectResponse
    {
        // TODO process payments
        // if fail - show message, go to checkout page
        // if success - go to wallet

        // TODO change tokens


        // TODO change money
        // TODO update init offer (stock & status)
        // TODO update match offer (stock & status)
        // TODO flush
        // TODO order status to closed

        // return $this->redirectToRoute('app_user_wallet_view');
        return dd($id);
    }
}
