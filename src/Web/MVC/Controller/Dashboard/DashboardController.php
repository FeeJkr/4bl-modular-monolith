<?php
declare(strict_types=1);

namespace App\Web\MVC\Controller\Dashboard;

use App\Web\MVC\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class DashboardController extends AbstractController
{
    public function showDashboard(): Response
    {
        return $this->render('dashboard.html.twig');
    }
}
