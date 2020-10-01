<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\UI\Http\Api\Category;

use App\Modules\Finances\Application\Category\CategoryService;
use App\Modules\Finances\Application\Category\Command\DeleteCategoryCommand;
use App\Modules\Finances\Domain\Category\CategoryId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class DeleteCategoryAction extends AbstractController
{
    private CategoryService $categoryService;

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
