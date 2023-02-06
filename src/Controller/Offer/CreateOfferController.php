<?php

namespace App\Controller\Offer;

use App\Entity\User;
use App\Form\CreateOfferFormType;
use App\Service\DataTransformer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateOfferController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em
    ) {
    }

    #[Route('/order/create')]
    public function view(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();

        $form = $this->createForm(CreateOfferFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();

            $offer = DataTransformer::formToOffer($formData, $user);

            $this->em->persist($offer);
            $this->em->flush();

            return $this->redirectToRoute('app_trade');
        }

        return $this->render('order/index.html.twig', [
            'title' => 'Create order',
            'form' => $form->createView(),
        ]);
    }
}
