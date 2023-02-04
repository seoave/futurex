<?php

namespace App\Controller\User;

use App\Entity\Offer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserTrading extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em
    ) {
    }

    #[Route('/trade', name: 'app_trade')]
    public function view(Request $request): Response
    {
        $message = $request->query->get('message') ?: '';
        $userId = 9; // TODO get current user id from session
        $repository = $this->em->getRepository(Offer::class);

        $offers = $repository->findBy([], ['id' => 'ASC']);
        $openOffer = $repository->findOneByOpen($userId);
        $matchingOffers = null;

        if ($openOffer) {
            $matchingOffers = $repository->findAllEqualOrLessThanRate(
                $openOffer->getRate(), $openOffer->getOfferType()
            );
        }

        return $this->render('trade/index.html.twig', [
            'title' => 'Trade',
            'offers' => $offers,
            'matchingOffers' => $matchingOffers,
            'openOffer' => $openOffer,
            'message' => $message,
        ]);
    }
}
