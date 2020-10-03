<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\UI\Http\Api\Category;

use App\Modules\Finances\Application\Category\CategoryService;
use App\Modules\Finances\Application\Category\Query\FetchAllCategoriesQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class FetchAllCategoriesAction extends AbstractController
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $query = new FetchAllCategoriesQuery(
            $request->get('user_id')
        );

        return $this->json($this->categoryService->fetchAll($query)->toArray());
    }
}
