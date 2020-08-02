<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SymfonyController;

/**
 * @method User getUser()
 */
abstract class AbstractController extends SymfonyController
{
}
