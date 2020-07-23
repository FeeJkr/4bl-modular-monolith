<?php
declare(strict_types=1);

namespace App\UI\Web\Action\Category;

use App\Category\Application\CategoryService;
use App\Category\Application\Command\DeleteCategoryCommand;
use App\Category\SharedKernel\CategoryId;
use App\UI\Web\Action\Action;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class DeleteCategoryAction extends Action
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $this->categoryService->deleteCategory(
            new DeleteCategoryCommand(
                CategoryId::fromInt((int) $request->get('id')),
                $request->get('user_id')
            )
        );

        return $this->json([], Response::HTTP_NO_CONTENT);
    }
}
