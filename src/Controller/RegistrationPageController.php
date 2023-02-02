<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationPageController extends AbstractController
{
    #[Route('/registration', name: 'registration_page')]
    public function registration(): Response
    {
        return $this->render('registration/index.html.twig', [
            'title' => 'Registration',
        ]);
    }
}
