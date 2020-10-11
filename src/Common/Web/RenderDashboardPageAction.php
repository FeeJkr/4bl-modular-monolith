<?php
declare(strict_types=1);

namespace App\Common\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class RenderDashboardPageAction extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render('@Common/dashboard.html.twig');
    }
}
