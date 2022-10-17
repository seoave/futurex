<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserProfile
{
    #[Route('user/{slug}')]
    public function show(string $slug): Response
    {
        return new Response('User profile ' . $slug);
    }
}
