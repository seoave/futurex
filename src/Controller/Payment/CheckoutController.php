<?php
declare(strict_types=1);

namespace App\Controller\Payment;

use App\Repository\OfferRepository;
use App\Service\OfferService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CheckoutController extends AbstractController
{
    #[Route('/order/checkout/match-{match}/actual-{actual}', name: 'app_payment_checkout_index')]
    public function index(int $match, int $actual, OfferRepository $repository, OfferService $service): Response
    {
        $matchOffer = $repository->find($match);
        $actualOffer = $repository->find($actual);

        if ($matchOffer && $actualOffer) {
            $service->block($matchOffer);
            $service->block($actualOffer);
        }

        // TODO block/unblock timer

        return $this->render('payment/checkout.html.twig', [
            'title' => 'Checkout',
            'matchOffer' => $matchOffer,
            'actualOffer' => $actualOffer,
        ]);
    }
}
