<?php
declare(strict_types=1);

namespace App\UI\Web\Action;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

abstract class Action extends AbstractController
{
    abstract public function __invoke(Request $request): JsonResponse;
}
