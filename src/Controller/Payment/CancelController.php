<?php
declare(strict_types=1);

namespace App\Controller\Payment;

use App\Repository\OfferRepository;
use App\Service\OfferService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CancelController extends AbstractController
{
    #[Route('/order/cancel/match-{match}/actual-{actual}', name: 'app_payment_cancel_index')]
    public function index(int $match, int $actual, OfferRepository $repository, OfferService $service): RedirectResponse
    {
        $matchOffer = $repository->find($match);
        $actualOffer = $repository->find($actual);

        if ($matchOffer && $actualOffer) {
            $service->unBlock($matchOffer);
            $service->unBlock($actualOffer);
        }

        return $this->redirectToRoute('app_user_trade_view');
    }
}
