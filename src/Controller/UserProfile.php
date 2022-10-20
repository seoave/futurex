<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserProfile
{
    #[Route('user/profile/{slug}')]
    public function view(string $slug): Response
    {
        return new Response('User profile ' . $slug);
    }

    #[Route('user/edit/{slug}')]
    public function edit(string $slug): Response
    {
        return new Response('Edit user profile ' . $slug);
    }

    #[Route('/api/v1/json/user/{slug}')]
    public function get(string $slug): Response
    {
        return new Response('Get user data ' . $slug);
    }
}
