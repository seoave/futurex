<?php

namespace App\Controller\Order;

use App\Entity\Offer;
use App\Entity\User;
use App\Form\CreateOrderFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateOrderController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em
    ) {
    }

    #[Route('/order/create')]
    public function view(Request $request): Response
    {
        $repo = $this->em->getRepository(User::class);
        $user = $repo->find(9);

        $form = $this->createForm(CreateOrderFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $offer = new Offer();
            $offer->setUser($user);
            $offer->setCurrency($formData['currency']);
            $offer->setExchangedCurrency($formData['exchangedCurrency']);
            $offer->setAmount($formData['amount']);
            $offer->setRate($formData['rate']);
            $offer->setStock($formData['amount']);
            $offer->setOfferType($formData['offerType']);

            $this->em->persist($offer);
            $this->em->flush();
        }

        return $this->render('order/index.html.twig', [
            'title' => 'Create order',
            'form' => $form->createView(),
        ]);
    }
}
