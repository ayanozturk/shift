<?php

namespace App\Controller;

use App\Entity\Shift;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
