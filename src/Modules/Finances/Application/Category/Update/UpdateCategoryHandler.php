<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\Update;

use App\Modules\Finances\Domain\Category\CategoryRepository;

final class UpdateCategoryHandler
{
    private CategoryRepository $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(UpdateCategoryCommand $command): void
    {
        $category = $this->repository->fetchById($command->getCategoryId(), $command->getUserId());

        $category->update($command->getCategoryName(), $command->getCategoryType(), $command->getCategoryIcon());

        $this->repository->save($category);
    }
}
