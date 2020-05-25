<?php

namespace App\Controller\Account;

use App\Billing\BillingConfig;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Onboarding
 */
class Onboarding extends AbstractController
{
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
