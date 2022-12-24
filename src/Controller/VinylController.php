<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\String\UnicodeString;
use Symfony\Contracts\Cache\CacheInterface;

use function Symfony\Component\String\u;

class VinylController extends AbstractController
{

    public function __construct(
       private CacheInterface $cache
    ) {

    }

    #[Route('/vinyls/{slug}', name: 'vinyls_beatles')]
    public function show(?string $slug = null): Response
    {
        dd($this->cache->get('vinyls_' . $slug, function () use ($slug){
           return new UnicodeString($slug);
        }));

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
