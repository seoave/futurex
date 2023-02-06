<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LogoutController extends AbstractController
{
    #[Route('/logout', name: 'app_logout')]
    public function index(): RedirectResponse
    {
        return $this->redirectToRoute('app_login');
    }
}
