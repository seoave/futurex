<?php

namespace App\Controller\Order;

use App\Entity\Offer;
use App\Entity\User;
use App\Form\CreateOrderFormType;
use App\Service\DataTransformer;
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

            var_dump($formData);

            $offer = DataTransformer::formToOffer($formData, $user);

            $this->em->persist($offer);
            $this->em->flush();

            return $this->redirectToRoute('trade');
        }

        return $this->render('order/index.html.twig', [
            'title' => 'Create order',
            'form' => $form->createView(),
        ]);
    }
}
