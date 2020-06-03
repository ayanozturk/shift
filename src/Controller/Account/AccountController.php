<?php

namespace App\Controller\Account;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AccountController
 */
class AccountController extends AbstractController
{
    public function details(): Response
    {
        return $this->render('account/details.twig');
    }
}
