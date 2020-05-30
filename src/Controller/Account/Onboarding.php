<?php

namespace App\Controller\Account;

use App\Billing\BillingConfig;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Onboarding
 */
class Onboarding extends AbstractController
{

    public function createAccount(): Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        return $this->render('account/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function checkout(BillingConfig $billingConfig): Response
    {
        return $this->render(
            'account/checkout.html.twig',
            [
                'siteName' => $billingConfig->getSiteName(),
                'planName' => $billingConfig->getPlanName(),
            ]
        );
    }
}
