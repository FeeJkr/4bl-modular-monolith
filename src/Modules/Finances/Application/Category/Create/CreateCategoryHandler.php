<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\Create;

use App\Modules\Finances\Domain\Category\Category;
use App\Modules\Finances\Domain\Category\CategoryRepository;
use App\Modules\Finances\Domain\Category\CategoryType;
use App\Modules\Finances\Domain\User\UserId;

final class CreateCategoryHandler
{
    private CategoryRepository $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(CreateCategoryCommand $command): void
    {
        $category = Category::createNew(
            UserId::fromInt($command->getUserId()),
            $command->getCategoryName(),
            new CategoryType($command->getCategoryType()),
            $command->getCategoryIcon()
        );

        $this->repository->store($category);
    }
}
