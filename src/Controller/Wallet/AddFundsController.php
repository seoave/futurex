<?php

namespace App\Controller\Wallet;

use App\Entity\Wallet;
use App\Form\AddFundsWalletType;
use App\Repository\WalletRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddFundsController extends AbstractController
{
    #[Route('/my/wallet/add', name: 'app_wallet_add')]
    public function view(Request $request, WalletRepository $walletRepository, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(AddFundsWalletType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $currency = $formData['currency'];

            $user = $this->getUser();

            $wallet = $walletRepository->findOneBy([
                'currency' => $currency->getId(),
                'owner' => $user,
            ]);

            if ($wallet === null) {
                $newWallet = new Wallet($user, $currency);
                $newWallet->setAmount($formData['amount']);
                $em->persist($newWallet);
            } else {
                $wallet->setAmount($wallet->getAmount() + $formData['amount']);
            }

            $em->flush();

            return $this->redirectToRoute('app_user_wallet');
        }

        return $this->render('wallet/add-funds.html.twig', [
            'title' => 'Add funds',
            'form' => $form->createView(),
        ]);
    }
}
