<?php
declare(strict_types=1);

namespace App\Controller\Payment;

use App\Repository\OfferRepository;
use App\Repository\OrderRepository;
use App\Service\OfferService;
use App\Service\PaymentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PaymentController extends AbstractController
{
    public function __construct(
        private readonly OrderRepository $orderRepository,
        private readonly PaymentService $paymentService,
        private readonly OfferService $offerService,
        private readonly OfferRepository $offerRepository
    ) {
    }

    #[Route('/order/pay/{id}', name: 'app_payment_order_view')]
    public function view(int $id): RedirectResponse
    {
        $order = $this->orderRepository->find($id);

        if ($order === null) {
            $this->addFlash('notice', 'Order not found');
            $this->redirectToRoute('app_payment_checkout_index'); // TODO check route
        }

        $transfer = $this->paymentService->orderTransfer($order);

        if (! $transfer) {
            $this->addFlash('notice', 'Transfer went wrong');
            $this->redirectToRoute('app_payment_checkout_index'); // TODO check route
        }

        $this->offerService->updateOrderOffersStockAndStatus($order);

        $order->setStatus('closed');
        $this->orderRepository->save($order);

        // return $this->redirectToRoute('app_user_wallet_view');
        return dd($id);
    }
}
