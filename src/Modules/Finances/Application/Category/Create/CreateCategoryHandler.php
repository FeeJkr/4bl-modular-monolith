<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\Create;

use App\Modules\Finances\Domain\Category\Category;
use App\Modules\Finances\Domain\Category\CategoryRepository;
use App\Modules\Finances\Domain\Category\CategoryType;
use App\Modules\Finances\Domain\User\UserContext;
use App\Modules\Finances\Domain\User\UserId;

final class CreateCategoryHandler
{
    private CategoryRepository $repository;
    private UserContext $userContext;

    public function __construct(CategoryRepository $repository, UserContext $userContext)
    {
        $this->repository = $repository;
        $this->userContext = $userContext;
    }

    public function __invoke(CreateCategoryCommand $command): void
    {
        $category = Category::createNew(
            $this->userContext->getUserId(),
            $command->getCategoryName(),
            new CategoryType($command->getCategoryType()),
            $command->getCategoryIcon()
        );

        $this->repository->store($category);
    }
}
