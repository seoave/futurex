<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $traders = $this->userRepository->findAll();

        return $this->render('home/index.html.twig', [
            'title' => 'FUTUREX',
            'traders' => ! empty($traders) ? $traders : [],
        ]);
    }
}
