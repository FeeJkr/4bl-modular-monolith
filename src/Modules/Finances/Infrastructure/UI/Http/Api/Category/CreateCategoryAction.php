<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\UI\Http\Api\Category;

use App\Modules\Finances\Application\Category\CategoryService;
use App\Modules\Finances\Application\Category\Command\CreateCategoryCommand;
use App\Modules\Finances\Domain\Category\CategoryType;
use App\UI\Web\Action\Action;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class CreateCategoryAction extends Action
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $this->categoryService->createCategory(
            new CreateCategoryCommand(
                $request->get('user_id'),
                $request->get('category_name'),
                new CategoryType($request->get('category_type')),
                $request->get('category_icon')
            )
        );

        return $this->json([], Response::HTTP_NO_CONTENT);
    }
}
