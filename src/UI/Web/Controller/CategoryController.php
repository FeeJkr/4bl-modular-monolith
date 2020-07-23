<?php
declare(strict_types=1);

namespace App\UI\Web\Controller;

use App\Category\Application\CategoryService;
use App\Category\Application\Command\CreateNewCategoryCommand;
use App\Category\Application\Command\DeleteCategoryCommand;
use App\Category\Application\Command\UpdateCategoryCommand;
use App\Category\Domain\CategoryException;
use App\Category\ReadModel\CategoryReadModel;
use App\Category\ReadModel\CategoryReadModelException;
use App\Category\ReadModel\Query\FetchAllQuery;
use App\Category\ReadModel\Query\FetchOneByIdQuery;
use App\Category\SharedKernel\CategoryId;
use App\Category\SharedKernel\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class CategoryController extends AbstractController
{
    private $categoryReadModel;
    private $categoryService;

    public function __construct(CategoryReadModel $categoryReadModel, CategoryService $categoryService)
    {
        $this->categoryReadModel = $categoryReadModel;
        $this->categoryService = $categoryService;
    }

    public function fetchAll(Request $request): JsonResponse
    {
        $query = new FetchAllQuery($request->get('user_id'));

        return $this->json(
            $this->categoryReadModel->fetchAll($query)->toArray()
        );
    }

    public function fetchOneById(Request $request): JsonResponse
    {
        try {
            $query = new FetchOneByIdQuery(
                $request->get('user_id'),
                CategoryId::fromInt((int) $request->get('id'))
            );

            return $this->json(
                $this->categoryReadModel->fetchOneById($query)
            );
        } catch (CategoryReadModelException $exception) {
            return $this->json(
                ['error' => $exception->getMessage()],
                Response::HTTP_NOT_FOUND
            );
        }
    }

    public function create(Request $request): JsonResponse
    {
        try {
            $this->categoryService->createNewCategory(
                new CreateNewCategoryCommand(
                    $request->get('user_id'),
                    $request->get('category_name'),
                    new CategoryType($request->get('category_type')),
                    $request->get('category_icon')
                )
            );

            return $this->json([], Response::HTTP_NO_CONTENT);
        } catch (Throwable $exception) {
            return $this->json(['error' => 'Unexpected error.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete(Request $request): JsonResponse
    {
        try {
            $this->categoryService->deleteCategory(
                new DeleteCategoryCommand(
                    CategoryId::fromInt((int) $request->get('id')),
                    $request->get('user_id')
                )
            );

            return $this->json([], Response::HTTP_NO_CONTENT);
        } catch (Throwable $exception) {
            return $this->json(['error' => 'Unexpected error.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request): JsonResponse
    {
        try {
            $this->categoryService->updateCategory(
                new UpdateCategoryCommand(
                    CategoryId::fromInt((int) $request->get('id')),
                    $request->get('user_id'),
                    $request->get('category_name'),
                    new CategoryType($request->get('category_type')),
                    $request->get('category_icon')
                )
            );

            return $this->json([], Response::HTTP_NO_CONTENT);
        } catch (CategoryException $exception) {
            return $this->json(['error' => $exception->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }
}
