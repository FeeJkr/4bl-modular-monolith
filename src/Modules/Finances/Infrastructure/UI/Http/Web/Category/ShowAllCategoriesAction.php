<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\UI\Http\Web\Category;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class ShowAllCategoriesAction extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render('@Finances/Category/index.html.twig');
    }
}
