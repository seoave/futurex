<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginPageController extends AbstractController
{
    #[Route('/login_page', name: 'login')]
    public function login(): Response
    {
        return $this->render('login/index_login.html.twig', [
            'title' => 'Login',
        ]);
    }
}
