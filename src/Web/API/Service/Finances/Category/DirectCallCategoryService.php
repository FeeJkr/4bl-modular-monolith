<?php
declare(strict_types=1);

namespace App\Web\API\Service\Finances\Category;

use App\Modules\Finances\Application\Category\CategoryContract;
use App\Modules\Finances\Application\Category\Create\CreateCategoryCommand;
use App\Modules\Finances\Application\Category\Delete\DeleteCategoryCommand;
use App\Modules\Finances\Application\Category\GetAll\GetAllCategoriesQuery;
use App\Modules\Finances\Application\Category\GetOneById\GetOneCategoryByIdQuery;
use App\Modules\Finances\Application\Category\Update\UpdateCategoryCommand;
use App\Web\API\Request\Finances\Category\CreateCategoryRequest;
use App\Web\API\Request\Finances\Category\DeleteCategoryRequest;
use App\Web\API\Request\Finances\Category\GetAllCategoriesRequest;
use App\Web\API\Request\Finances\Category\GetOneCategoryByIdRequest;
use App\Web\API\Request\Finances\Category\UpdateCategoryRequest;
use App\Web\API\Response\Finances\Category\CategoriesResponse;
use App\Web\API\Response\Finances\Category\CategoryResponse;
use App\Web\API\Service\Finances\User\UserService;

final class DirectCallCategoryService implements CategoryService
{
    private UserService $userService;
    private CategoryContract $categoryContract;

    public function __construct(UserService $userService, CategoryContract $categoryContract)
    {
        $this->userService = $userService;
        $this->categoryContract = $categoryContract;
    }

    public function createCategory(CreateCategoryRequest $request): void
    {
        $userId = $this->userService->getUserIdByToken($request->getUserToken());
        $command = new CreateCategoryCommand(
            $userId,
            $request->getCategoryName(),
            $request->getcategoryType(),
            $request->getCategoryIcon()
        );

        $this->categoryContract->createCategory($command);
    }

    public function deleteCategory(DeleteCategoryRequest $request): void
    {
        $userId = $this->userService->getUserIdByToken($request->getUserToken());
        $command = new DeleteCategoryCommand(
            $request->getCategoryId(),
            $userId
        );

        $this->categoryContract->deleteCategory($command);
    }

    public function updateCategory(UpdateCategoryRequest $request): void
    {
        $userId = $this->userService->getUserIdByToken($request->getUserToken());
        $command = new UpdateCategoryCommand(
            $request->getCategoryId(),
            $userId,
            $request->getCategoryName(),
            $request->getCategoryType(),
            $request->getCategoryIcon()
        );

        $this->categoryContract->updateCategory($command);
    }

    public function getAllCategories(GetAllCategoriesRequest $request): CategoriesResponse
    {
        $userId = $this->userService->getUserIdByToken($request->getUserToken());
        $query = new GetAllCategoriesQuery($userId);

        return CategoriesResponse::createFromCollection(
            $this->categoryContract->getAllCategories($query)
        );
    }

    public function getOneCategoryById(GetOneCategoryByIdRequest $request): CategoryResponse
    {
        $userId = $this->userService->getUserIdByToken($request->getUserToken());
        $query = new GetOneCategoryByIdQuery($userId, $request->getCategoryId());

        $category = $this->categoryContract->getOneCategoryById($query);

        return new CategoryResponse(
            $category->getId(),
            $category->getUserId(),
            $category->getName(),
            $category->getType(),
            $category->getIcon(),
            $category->getCreatedAt()
        );
    }
}
