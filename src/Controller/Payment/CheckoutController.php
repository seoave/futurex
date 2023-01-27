<?php
declare(strict_types=1);

namespace App\Controller\Payment;

use App\Entity\Order;
use App\Repository\OfferRepository;
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
    ) {
    }

    #[Route('/order/checkout/{match}/{actual}', name: 'app_payment_checkout_index')]
    public function index(int $match, int $actual): Response
    {
        $disabled = false;

        $requiredFundsValidation = $this->paymentService->haveWalletsEnoughFunds($match, $actual);

        if (! $requiredFundsValidation['isEnough']) {
            $disabled = true;
            $message = 'Not Enough funds: ' . $requiredFundsValidation['message'];
            $this->addFlash('notice', $message);
        }

        $matchOffer = $this->offerRepository->find($match);
        $actualOffer = $this->offerRepository->find($actual);

        if ($matchOffer && $actualOffer) {
            $this->offerService->block($matchOffer);
            $this->offerService->block($actualOffer);
        }

        $draftOrder = $this->orderService::createOrder($actualOffer, $matchOffer);
        dd($draftOrder);

        // TODO block/unblock timer

        return $this->render('payment/checkout.html.twig', [
            'title' => 'Checkout',
            'matchOffer' => $matchOffer,
            'actualOffer' => $actualOffer,
            'disabled' => $disabled ? 'disabled' : '',
        ]);
    }
}
