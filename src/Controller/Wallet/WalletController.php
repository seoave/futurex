<?php
declare(strict_types=1);

namespace App\Controller\Wallet;

use App\Entity\User;
use App\Repository\WalletRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WalletController extends AbstractController
{
    #[Route('/my/wallet', name: 'app_user_wallet')]
    public function view(WalletRepository $repository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        /** @var User $user */
        $user = $this->getUser();

        $currencies = $repository->findAllUserFunds($user->getId());
        $tokens = $repository->findAllUserFunds($user->getId(), true);

        return $this->render('wallet/index.html.twig', [
            'title' => 'My Wallet',
            'currencies' => $currencies,
            'tokens' => $tokens,
        ]);
    }
}
