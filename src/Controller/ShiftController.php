<?php

namespace App\Controller;

use App\Entity\Shift;
use App\Entity\User;
use App\Form\ShiftType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ShiftController
 */
class ShiftController extends AbstractController
{
    public function list(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $userRepository = $entityManager->getRepository(User::class);
        $shiftRepository = $entityManager->getRepository(Shift::class);

        return $this->render('shift/index.html.twig', [
            'users' => $userRepository->findAll(),
            'shifts' => $shiftRepository->findAll(),
        ]);
    }

    public function create(Request $request, int $day): Response
    {
        $startDateTime = DateTime::createFromFormat('Y-m-d H:i', date('Y') . '-01-01 09:00');
        $startDateTime->modify('+' . $day - 1 . ' days');

        $shift = new Shift();
        $shift->setStartDate($startDateTime);
        $shift->setEndDate((clone $startDateTime)->modify('+8 hours'));

        $form = $this->createForm(ShiftType::class, $shift);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($shift);
            $entityManager->flush();

            return $this->redirectToRoute('shift-list');
        }

        return $this->render('shift/create.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function calendar(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $userRepository = $entityManager->getRepository(User::class);

        $users = $userRepository->findBy(['company' => $this->getUser()->company]) ?? [];

        $monday = new DateTime('Monday this week');
        $weekdays = [
            $monday->format('z'),
            $monday->modify('+1 day')->format('z'),
            $monday->modify('+1 day')->format('z'),
            $monday->modify('+1 day')->format('z'),
            $monday->modify('+1 day')->format('z'),
            $monday->modify('+1 day')->format('z'),
            $monday->modify('+1 day')->format('z'),
        ];

        return $this->render('shift/calendar.twig', [
            'company' => $this->getUser()->company,
            'monday' => $monday,
            'week' => (int) $monday->format('W'),
            'weekdays' => $weekdays,
            'users' => $users,
        ]);
    }
}
