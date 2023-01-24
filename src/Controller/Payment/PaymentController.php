<?php
declare(strict_types=1);

namespace App\Controller\Payment;

use App\Service\PaymentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PaymentController extends AbstractController
{
    #[Route('/order/pay/{match}/{actual}', name: 'app_payment_order_view')]
    public function view(int $match, int $actual, PaymentService $service): RedirectResponse
    {
        $requiredFundsValidation = $service->haveWalletsEnoughFunds($match, $actual);

        if (! $requiredFundsValidation['isEnough']) {
            $message = 'Not Enough funds: ' . $requiredFundsValidation['message'];
            $this->addFlash('notice', $message);

            return $this->redirectToRoute('app_payment_checkout_index', [
                'match' => $match,
                'actual' => $actual,
            ]);
        }

        $service->go($match, $actual);

        return $this->redirectToRoute('app_user_wallet_view');
    }
}
