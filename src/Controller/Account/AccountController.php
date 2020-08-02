<?php

namespace App\Controller\Account;

use App\Controller\AbstractController;
use App\Entity\Company;
use App\Form\CompanyType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AccountController
 */
class AccountController extends AbstractController
{
    public function details(): Response
    {
        return $this->render('account/details.twig', [
            'user' => $this->getUser(),
        ]);
    }

    public function company(Request $request): Response
    {
        $user = $this->getUser();
        $company = $user->company ?? new Company();

        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $user->company = $company;

            $entityManager->persist($company);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('account-details');
        }

        return $this->render('account/company.twig', [
            'form' => $form->createView(),
        ]);
    }
}
