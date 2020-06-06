<?php

namespace App\Controller\Account;

use App\Billing\BillingConfig;
use App\Entity\User;
use App\Events\UserCreatedEvent;
use App\Form\UserType;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Onboarding
 */
class Onboarding extends AbstractController
{

    public function createAccount(
        Request $request,
        EventDispatcherInterface $eventDispatcher
    ): Response {
        $user = new User();
        $user->setRoles([User::ROLE_ADMIN]);

        $form = $this->createForm(UserType::class, $user);
        $form->remove('roles');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $eventDispatcher->dispatch(new UserCreatedEvent($user));

            $this->addFlash(
                'notice',
                'Account created. Plese log in!'
            );

            return $this->redirectToRoute('login');
        }

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
