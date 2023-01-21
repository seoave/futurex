<?php
declare(strict_types=1);

namespace App\Controller\Payment;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CheckoutController extends AbstractController
{
    #[Route('/order/checkout/match-{match}/actual-{actual}', name: 'app_payment_checkout_index')]
    public function index(int $match, int $actual): Response
    {
        return $this->render('payment/checkout.html.twig', [
            'title' => 'Checkout',
            'match' => $match,
            'actual' => $actual,
        ]);
    }
}
