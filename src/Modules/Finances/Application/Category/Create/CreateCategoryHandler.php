<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\Create;

use App\Modules\Finances\Domain\Category\Category;
use App\Modules\Finances\Domain\Category\CategoryRepository;

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
            $command->getUserId(),
            $command->getCategoryName(),
            $command->getCategoryType(),
            $command->getCategoryIcon()
        );

        $this->repository->store($category);
    }
}
