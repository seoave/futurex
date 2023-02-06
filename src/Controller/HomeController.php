<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\WalletRepository;
use App\Service\WalletService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly WalletService $walletService,
    ) {
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $traders = $this->userRepository->findAll();

        $totalCurrenciesDeposits = $this->walletService->getTotalFundsByIsToken();
        $totalTokensDeposits = $this->walletService->getTotalFundsByIsToken(true);

        return $this->render('home/index.html.twig', [
            'title' => 'FUTUREX',
            'traders' => ! empty($traders) ? $traders : [],
            'currencies' => ! empty($totalCurrenciesDeposits) ? $totalCurrenciesDeposits : [],
            'tokens' => ! empty($totalTokensDeposits) ? $totalTokensDeposits : [],
        ]);
    }
}
