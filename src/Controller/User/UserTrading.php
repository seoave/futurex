<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserTrading extends AbstractController
{
    #[Route('/trade', name: 'trade')]
    public function view(): Response
    {
        return $this->render('trade/index.html.twig', [
            'title' => 'Trade',
        ]);
    }
}
