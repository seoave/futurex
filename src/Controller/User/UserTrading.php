<?php

namespace App\Controller\User;

use App\Entity\Offer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

class UserTrading extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em
    ) {
    }

    #[Route('/my/trade', name: 'app_trade')]
    public function view(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $message = $request->query->get('message') ?: '';
        $user = $this->getUser();

        if ($user === null) {
            throw new UserNotFoundException('Current user not found');
        }

        $repository = $this->em->getRepository(Offer::class);

        $offers = $repository->findBy([
            'user' => $user,
        ], ['id' => 'ASC']);
        $openOffer = $repository->findOneByOpen($user);
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
