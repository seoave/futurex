<?php
declare(strict_types=1);

namespace App\Controller\Payment;

use App\Repository\OfferRepository;
use App\Repository\OrderRepository;
use App\Service\OfferService;
use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CheckoutController extends AbstractController
{
    public function __construct(
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
        $newOrder = null;
        $matchOffer = $this->offerRepository->find($match);
        $actualOffer = $this->offerRepository->find($actual);

        if ($matchOffer === null) {
            $this->addFlash('notice', 'Match offer not found');

            return $this->redirectToRoute('app_user_trade_view');
        }

        if ($actualOffer === null) {
            $this->addFlash('notice', 'Current offer not found');

            return $this->redirectToRoute('app_user_trade_view');
        }

        // create draft order
        $draftOrder = $this->orderService->createOrder($actualOffer, $matchOffer);

        // if both funds exists
        $fundsValidation = $this->orderService->isFundsValid($draftOrder);

        // TODO refactor it
        if (! $fundsValidation['isEnough']) {
            $disabled = true;
            $message = 'Not Enough funds: ' . $fundsValidation['message'];
            $this->addFlash('notice', $message);
        }

        // block both offers
        if ($fundsValidation['isEnough']) {
            $this->offerService->block($matchOffer);
            $this->offerService->block($actualOffer);

            $newOrder = $isOrderExists = $this->orderRepository->findOneByDraftOrder($draftOrder);

            if ($isOrderExists === null) {
                $this->orderRepository->save($draftOrder, true);
                $newOrder = $draftOrder;
            }
        }

        // TODO block/unblock 15 min timer,
        // TODO if not pay draft order and blocked offer will be canceled

        return $this->render('payment/checkout.html.twig', [
            'title' => 'Checkout',
            'matchOffer' => $matchOffer,
            'actualOffer' => $actualOffer,
            'order' => $newOrder,
            'disabled' => $disabled ? 'disabled' : '',
        ]);
    }
}
