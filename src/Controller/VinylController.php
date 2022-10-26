<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VinylController
{
    #[Route('/vinyls/{slug}', name: 'vinyls_beatles')]
    public function show(string $slug): Response
    {
        return new Response(sprintf('Group name: %s', $slug));
    }
}
