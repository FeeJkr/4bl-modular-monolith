<?php
declare(strict_types=1);

namespace App\Web\MVC\Controller\Finances;

use App\Web\MVC\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class CategoryController extends AbstractController
{
    public function showCategoriesPage(): Response
    {
        return $this->render('finances/category/index.html.twig');
    }
}
