<?php
declare(strict_types=1);

namespace App\Controller\Payment;

use App\Entity\Offer;
use App\Entity\Wallet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PaymentController extends AbstractController
{
    #[Route('/order/pay/{match}/{actual}', name: 'app_payment_order_view')]
    public function view(int $match, int $actual, EntityManagerInterface $em): RedirectResponse
    {
        // TODO token owner wallet: subtract token
        $matchOffer = $em->getRepository(Offer::class)->find($match);
        $actualOffer = $em->getRepository(Offer::class)->find($actual);

        if (empty($matchOffer) || empty($actualOffer)) {
            return $this->redirectToRoute('app_payment_checkout_index', [
                'message' => 'Offer not found, sorry',
            ]);
        }

        $matchUser = $matchOffer->getUser();
        $actualUser = $actualOffer->getUser();

        if ($matchUser === null || $actualUser === null) {
            return $this->redirectToRoute('app_payment_checkout_index', [
                'message' => 'User not found, sorry',
            ]);
        }

        $matchTokenWallet = $em->getRepository(Wallet::class)->findOneBy([
            'owner' => $matchUser->getId(),
            'currency' => $matchOffer->getCurrency(),
        ]);

        $actualTokenWallet = $em->getRepository(Wallet::class)->findOneBy([
            'owner' => $actualUser->getId(),
            'currency' => $matchOffer->getCurrency(),
        ]);

        if ($matchTokenWallet === null || $actualTokenWallet === null) {
            return $this->redirectToRoute('app_payment_checkout_index', [
                'message' => 'Wallet not found, sorry',
            ]);
        }

        // TODO debit tokens from the account
        $matchTokenWalletAmount = $matchTokenWallet->getAmount();
        $matchTokenWallet->setAmount($matchTokenWalletAmount - $matchOffer->getAmount());

        // TODO credit the tokens to the account
        $actualTokenWalletAmount = $actualTokenWallet->getAmount();
        $actualTokenWallet->setAmount($actualTokenWalletAmount + $matchOffer->getAmount());

        // TODO debit money from the account
        $matchCurrencyWallet = $em->getRepository(Wallet::class)->findOneBy([
            'owner' => $matchUser->getId(),
            'currency' => $matchOffer->getExchangedCurrency(),
        ]);

        $actualCurrencyWallet = $em->getRepository(Wallet::class)->findOneBy([
            'owner' => $actualUser->getId(),
            'currency' => $matchOffer->getExchangedCurrency(),
        ]);

        if ($matchCurrencyWallet === null || $actualCurrencyWallet === null) {
            return $this->redirectToRoute('app_payment_checkout_index', [
                'message' => 'Currency Wallets not found, sorry',
            ]);
        }

        $actualCurrencyWalletAmount = $actualCurrencyWallet->getAmount();
        // TODO set debit token amount, example taken
        $currencyDebit = $matchOffer->getAmount() * $matchOffer->getRate();
        $actualCurrencyWallet->setAmount($actualCurrencyWalletAmount - $currencyDebit);
        $currencyCredit = $matchCurrencyWallet->getAmount() + $currencyDebit;
        $matchCurrencyWallet->setAmount($currencyCredit);

        $em->persist($matchTokenWallet);
        $em->persist($actualTokenWallet);
        $em->persist($actualCurrencyWallet);
        $em->persist($matchCurrencyWallet);
        $em->flush();

        dd($matchCurrencyWallet);

        return $this->redirectToRoute('app_user_wallet_view');
    }
}
