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
    ) {
    }

    #[Route('/order/pay/{id}', name: 'app_payment_order_view')]
    public function view(int $id): RedirectResponse
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $order = $this->orderRepository->find($id);

        if ($order === null) {
            $this->addFlash('notice', 'Order not found');
            $this->redirectToRoute('app_trade');
        }

        $matchId = $order->getMatchOffer()->getId();
        $actualId = $order->getInitialOffer()->getId();
        $url = '/order/checkout/' . $matchId . '/' . $actualId;

        $transfer = $this->paymentService->orderTransfer($order);

        if (! $transfer) {
            $this->addFlash('notice', 'Transfer went wrong');
            $this->redirect($url);
        }

        $isOffersUpdated = $this->offerService->updateOrderOffersStockAndStatus($order);

        if ($isOffersUpdated) {
            $order->setStatus('closed');
            $this->orderRepository->save($order, true);
        }

        return $this->redirectToRoute('app_trade');
    }
}
