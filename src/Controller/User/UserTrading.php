<?php

namespace App\Controller\User;

use App\Entity\Offer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserTrading extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em
    ) {
    }

    #[Route('/trade', name: 'trade')]
    public function view(): Response
    {
        $repository = $this->em->getRepository(Offer::class);
        $offers = $repository->findBy([], ['id' => 'DESC']);
        $matchingOffers = $repository->findAllEqualOrLessThanRate(5000);

        return $this->render('trade/index.html.twig', [
            'title' => 'Trade',
            'offers' => $offers,
            'matchingOffers' => $matchingOffers,
        ]);
    }
}
