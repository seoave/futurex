<?php
declare(strict_types=1);

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserWalletController extends AbstractController
{
    #[Route('/my/wallet', name: 'app_user_wallet_view')]
    public function view(): Response
    {
        return $this->render('wallet/index.html.twig');
    }
}
