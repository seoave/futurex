<?php
declare(strict_types=1);

namespace App\Controller\Wallet;

use App\Repository\WalletRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WalletController extends AbstractController
{
    #[Route('/my/wallet', name: 'app_user_wallet_view')]
    public function view(WalletRepository $repository): Response
    {
        $userId = 9;
        $currencies = $repository->findAllUserFunds($userId);
        $tokens = $repository->findAllUserFunds($userId, true);

        return $this->render('wallet/index.html.twig', [
            'title' => 'My Wallet',
            'currencies' => $currencies,
            'tokens' => $tokens,
        ]);
    }
}
