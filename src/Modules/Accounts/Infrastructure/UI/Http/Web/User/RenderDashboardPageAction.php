<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\UI\Http\Web\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class RenderDashboardPageAction extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render('@Accounts/User/dashboard.html.twig');
    }
}
