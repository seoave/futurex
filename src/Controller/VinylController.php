<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function Symfony\Component\String\u;

class VinylController extends AbstractController
{
    #[Route('/vinyls/{slug}', name: 'vinyls_beatles')]
    public function show(?string $slug = null): Response
    {
        if ($slug !== null) {
            $title = u(str_replace('-', ' ', $slug))->title(allWords: true);
        } else {
            $title = 'Some vinyls';
        }

        return $this->render('base.html.twig', [
            'title' => $title,
        ]);
    }
}
