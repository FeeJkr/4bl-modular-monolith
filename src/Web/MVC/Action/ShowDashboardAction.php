<?php
declare(strict_types=1);

namespace App\Web\MVC\Action;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class ShowDashboardAction extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render('@Common/dashboard.html.twig');
    }
}
