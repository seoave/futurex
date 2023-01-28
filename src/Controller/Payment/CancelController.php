<?php
declare(strict_types=1);

namespace App\Controller\Payment;

use App\Repository\OfferRepository;
use App\Repository\OrderRepository;
use App\Service\OfferService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CancelController extends AbstractController
{
    public function __construct(
        private readonly OrderRepository $repository,
        private readonly OfferService $service,
    ) {
    }

    #[Route('/order/cancel/{id}', name: 'app_payment_cancel_index')]
    public function index(int $id): RedirectResponse
    {
        $order = $this->repository->find($id);

        if ($order === null) {
            $this->redirectToRoute('app_user_trade_view');
        }

        $initialOffer = $order->getInitialOffer();
        $matchOffer = $order->getMatchOffer();

        $this->service->unBlockDraft($initialOffer);
        $this->service->unBlockDraft($matchOffer);

        $this->repository->remove($order, true);

        return $this->redirectToRoute('app_user_trade_view');
    }
}
