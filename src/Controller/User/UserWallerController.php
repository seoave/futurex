<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserWallerController extends AbstractController
{
    #[Route('/my/wallet', name: 'wallet')]
    public function view(): Response
    {
        return $this->render('wallet/index.html.twig', [
            'title' => 'My wallet',
        ]);
    }
}
