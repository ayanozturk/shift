<?php

namespace App\Controller;

use App\Core\Exception\InvalidCurrentPasswordException;
use App\Core\PasswordUpdater;
use App\Entity\Shift;
use App\Entity\User;
use App\Form\PasswordChangeType;
use App\Form\ShiftType;
use App\Form\UserType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/employees")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="employee_list", methods={"GET"})
     */
    public function index(): Response
    {
        if ($this->getUser()->company) {
            $users = $this->getDoctrine()
                ->getRepository(User::class)
                ->findByCompany($this->getUser()->company);
        } else {
            $users = [];
        }

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/new", name="employee_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $user->company = $this->getUser()->company;

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToUserList();
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/shifts", name="employee_shifts", methods={"GET", "POST"})
     */
    public function userShifts(Request $request, User $user): Response
    {
        $shift = new Shift();
        $user->addShift($shift);

        $form = $this->createForm(ShiftType::class, $shift);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->persist($shift);
            $entityManager->flush();

            return $this->redirectToUserList();
        }

        return $this->render('user/userShifts.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->remove('plainPassword');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToUserList();
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->id, $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToUserList();
    }

    public function changePassword(
        Request $request,
        PasswordUpdater $passwordUpdater
    ): Response {

        /** @var User $user */
        $user = $this->getUser();
        $form = $this->createForm(PasswordChangeType::class, $this->getUser());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $currentPassword = $form->get('currentPassword')->getData();
            $plainPassword = $form->get('plainPassword')->getData();

            try {
                $passwordUpdater->updatePassword($user, $currentPassword, $plainPassword);
                $this->addFlash('notice', 'Password has successfully been changed');
                return $this->redirectToRoute('account-details');
            } catch (InvalidCurrentPasswordException $exception) {
                $form->addError(new FormError('Current password is not correct, please try again'));
            }
        }

        return $this->render('user/passwordChange.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function redirectToUserList(): Response
    {
        return $this->redirectToRoute('employee_list');
    }
}
