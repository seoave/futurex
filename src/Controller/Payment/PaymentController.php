<?php
declare(strict_types=1);

namespace App\Controller\Payment;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PaymentController extends AbstractController
{
    #[Route('/order/pay/{match}/{actual}', name: 'app_payment_order_view')]
    public function view(int $match, int $actual): RedirectResponse
    {
        // TODO
        return $this->redirectToRoute('app_user_wallet_view');
    }
}
