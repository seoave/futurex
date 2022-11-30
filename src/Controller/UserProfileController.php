<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserProfileController extends AbstractController
{
    #[Route('/users/{slug}')]
    public function view(int $slug): Response
    {
        return $this->render('user/index.html.twig', [
            'title' => 'Profile User ' . $slug,
            'userId' => 1,
            'name' => 'User 1',
            'email' => 'user1@mail.com',
        ]);
    }
}
