<?php
declare(strict_types=1);

namespace App\UI\Web\Controller;

use App\Application\Category\CategoryService;
use App\Application\Category\Command\CreateNewCategoryCommand;
use App\ReadModel\Category\CategoryReadModel;
use App\ReadModel\Category\CategoryReadModelException;
use App\ReadModel\Category\Query\FetchAllQuery;
use App\ReadModel\Category\Query\FetchOneByIdQuery;
use App\SharedKernel\Category\CategoryId;
use App\SharedKernel\Category\CategoryType;
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
}
