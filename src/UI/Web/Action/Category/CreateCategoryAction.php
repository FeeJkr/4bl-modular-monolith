<?php
declare(strict_types=1);

namespace App\UI\Web\Action\Category;

use App\Category\Application\CategoryService;
use App\Category\Application\Command\CreateCategoryCommand;
use App\Category\SharedKernel\CategoryType;
use App\UI\Web\Action\Action;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class CreateCategoryAction extends Action
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $this->categoryService->createNewCategory(
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
