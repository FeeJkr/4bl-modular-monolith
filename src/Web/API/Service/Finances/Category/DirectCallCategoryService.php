<?php
declare(strict_types=1);

namespace App\Web\API\Service\Finances\Category;

use App\Modules\Finances\Application\Category\Create\CreateCategoryCommand;
use App\Modules\Finances\Application\Category\Delete\DeleteCategoryCommand;
use App\Modules\Finances\Application\Category\GetAll\CategoriesCollection;
use App\Modules\Finances\Application\Category\GetAll\GetAllCategoriesQuery;
use App\Modules\Finances\Application\Category\GetOneById\CategoryDTO;
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
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class DirectCallCategoryService implements CategoryService
{
    private UserService $userService;
    private MessageBusInterface $bus;

    public function __construct(UserService $userService, MessageBusInterface $bus)
    {
        $this->userService = $userService;
        $this->bus = $bus;
    }

    public function createCategory(CreateCategoryRequest $request): void
    {
        $userId = $this->userService->getUserIdByToken($request->getUserToken());

        $this->bus->dispatch(
            new CreateCategoryCommand(
                $userId,
                $request->getCategoryName(),
                $request->getcategoryType(),
                $request->getCategoryIcon()
            )
        );
    }

    public function deleteCategory(DeleteCategoryRequest $request): void
    {
        $userId = $this->userService->getUserIdByToken($request->getUserToken());

        $this->bus->dispatch(
            new DeleteCategoryCommand(
                $request->getCategoryId(),
                $userId
            )
        );
    }

    public function updateCategory(UpdateCategoryRequest $request): void
    {
        $userId = $this->userService->getUserIdByToken($request->getUserToken());

        $this->bus->dispatch(
            new UpdateCategoryCommand(
                $request->getCategoryId(),
                $userId,
                $request->getCategoryName(),
                $request->getCategoryType(),
                $request->getCategoryIcon()
            )
        );
    }

    public function getAllCategories(GetAllCategoriesRequest $request): CategoriesResponse
    {
        $userId = $this->userService->getUserIdByToken($request->getUserToken());
        $query = new GetAllCategoriesQuery($userId);

        /** @var CategoriesCollection $result */
        $result = $this->bus
            ->dispatch($query)
            ->last(HandledStamp::class)
            ->getResult();

        return CategoriesResponse::createFromCollection($result);
    }

    public function getOneCategoryById(GetOneCategoryByIdRequest $request): CategoryResponse
    {
        $userId = $this->userService->getUserIdByToken($request->getUserToken());
        $query = new GetOneCategoryByIdQuery($userId, $request->getCategoryId());

        /** @var CategoryDTO $result */
        $result = $this->bus
            ->dispatch($query)
            ->last(HandledStamp::class)
            ->getResult();

        return new CategoryResponse(
            $result->getId(),
            $result->getUserId(),
            $result->getName(),
            $result->getType(),
            $result->getIcon(),
            $result->getCreatedAt()
        );
    }
}
