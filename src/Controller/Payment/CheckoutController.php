<?php
declare(strict_types=1);

namespace App\Controller\Payment;

use App\Entity\Order;
use App\Repository\OfferRepository;
use App\Repository\OrderRepository;
use App\Service\OfferService;
use App\Service\OrderService;
use App\Service\PaymentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CheckoutController extends AbstractController
{
    public function __construct(
        private readonly PaymentService $paymentService,
        private readonly OfferRepository $offerRepository,
        private readonly OfferService $offerService,
        private readonly OrderService $orderService,
        private readonly OrderRepository $orderRepository
    ) {
    }

    #[Route('/order/checkout/{match}/{actual}', name: 'app_payment_checkout_index')]
    public function index(int $match, int $actual): Response
    {
        $disabled = false;
        $matchOffer = $this->offerRepository->find($match);
        $actualOffer = $this->offerRepository->find($actual);

        // create draft order
        if ($matchOffer && $actualOffer) {
            $draftOrder = $this->orderService->createOrder($actualOffer, $matchOffer);
        }

        // if both funds exists
        $fundsValidation = $this->orderService->isFundsValid($draftOrder);

        // TODO refactor it
        if (! $fundsValidation['isEnough']) {
            $disabled = true;
            $message = 'Not Enough funds: ' . $fundsValidation['message'];
            $this->addFlash('notice', $message);
        }

        // block both offers
        if ($matchOffer && $actualOffer && $fundsValidation['isEnough']) {
            $this->offerService->block($matchOffer);
            $this->offerService->block($actualOffer);
            $this->orderRepository->save($draftOrder);
        }

        // TODO block/unblock 15 min timer,
        // TODO if not pay draft order and blocked offer will be canceled

        return $this->render('payment/checkout.html.twig', [
            'title' => 'Checkout',
            'matchOffer' => $matchOffer,
            'actualOffer' => $actualOffer,
            'order' => $draftOrder,
            'disabled' => $disabled ? 'disabled' : '',
        ]);
    }
}
