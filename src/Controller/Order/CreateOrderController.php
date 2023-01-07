<?php

namespace App\Controller\Order;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateOrderController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    #[Route('/order/create')]
    public function view(): Response
    {
        return $this->render('order/index.html.twig', [
            'title' => 'Create order',
        ]);
    }
}
