<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\Update;

use App\Modules\Finances\Domain\Category\CategoryId;
use App\Modules\Finances\Domain\Category\CategoryRepository;
use App\Modules\Finances\Domain\Category\CategoryType;
use App\Modules\Finances\Domain\User\UserContext;
use App\Modules\Finances\Domain\User\UserId;

final class UpdateCategoryHandler
{
    private CategoryRepository $repository;
    private UserContext $userContext;

    public function __construct(CategoryRepository $repository, UserContext $userContext)
    {
        $this->repository = $repository;
        $this->userContext = $userContext;
    }

    public function __invoke(UpdateCategoryCommand $command): void
    {
        $categoryId = CategoryId::fromInt($command->getCategoryId());
        $categoryType = new CategoryType($command->getCategoryType());

        $category = $this->repository->fetchById($categoryId, $this->userContext->getUserId());

        $category->update($command->getCategoryName(), $categoryType, $command->getCategoryIcon());

        $this->repository->save($category);
    }
}
