<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 */
class DefaultController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('default/index.html.twig');
    }
}
