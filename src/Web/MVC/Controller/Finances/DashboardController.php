<?php
declare(strict_types=1);

namespace App\Web\MVC\Controller\Finances;

use App\Web\MVC\Controller\AbstractController;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Response;

final class DashboardController extends AbstractController
{
    public function showDashboard(): Response
    {
        return $this->render('finances/dashboard.html.twig');
    }
}
