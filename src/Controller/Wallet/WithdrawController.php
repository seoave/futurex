<?php
declare(strict_types=1);

namespace App\Controller\Wallet;

use App\Entity\User;
use App\Entity\Wallet;
use App\Form\AddFundsWalletType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WithdrawController extends AbstractController
{
    #[Route('/my/wallet/withdraw', name: 'app_wallet_withdraw_view')]
    public function view(Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(AddFundsWalletType::class);
        $userId = 9;
        $bossId = 12;
        $boss = $em->getRepository(User::class)->find(12);
        $withdrawalFeeKoefficient = 0.03;
        $errorMessage = 'The withdrawal fee is 3% of the amount';

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $wallet = $em->getRepository(Wallet::class)->findOneBy([
                'owner' => $userId,
                'currency' => $data['currency'],
            ]);

            $withdrawalFee = $withdrawalFeeKoefficient * $data['amount'];
            $withdrawalAmount = $data['amount'] + $withdrawalFee;

            if ($wallet && $wallet->getAmount() > $withdrawalAmount) {
                $bossWallet = $em->getRepository(Wallet::class)->findOneBy([
                    'owner' => $bossId,
                    'currency' => $data['currency'],
                ]);

                $wallet->setAmount($wallet->getAmount() - $withdrawalAmount);

                // TODO send money to trader's card

                if ($bossWallet) {
                    $bossWallet->setAmount($withdrawalAmount);
                    $em->persist($bossWallet);
                } else {
                    $newBossWallet = new Wallet();
                    $newBossWallet->setOwner($boss);
                    $newBossWallet->setCurrency($data['currency']);
                    $newBossWallet->setAmount($withdrawalAmount);
                    $em->persist($newBossWallet);
                }
                $em->flush();

                return $this->redirectToRoute('app_user_wallet_view');

            }

            $errorMessage = 'There is not enough money. Reduce amount or choose another currency.';
        }

        return $this->render('wallet/add-funds.html.twig', [
            'title' => 'Withdraw',
            'form' => $form->createView(),
            'errorMessage' => $errorMessage,
        ]);
    }
}
