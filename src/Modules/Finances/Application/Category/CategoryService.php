<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category;

use App\Modules\Finances\Application\Category\Command\CreateCategoryCommand;
use App\Modules\Finances\Application\Category\Command\DeleteCategoryCommand;
use App\Modules\Finances\Application\Category\Command\UpdateCategoryCommand;
use App\Modules\Finances\Domain\Category\Category;
use App\Modules\Finances\Domain\Category\CategoryRepository;

final class CategoryService
{
    private CategoryRepository $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createCategory(CreateCategoryCommand $command): void
    {
        $category = Category::createNew(
            $command->getUserId(),
            $command->getCategoryName(),
            $command->getCategoryType(),
            $command->getCategoryIcon()
        );

        $this->repository->store($category);
    }

    public function deleteCategory(DeleteCategoryCommand $command): void
    {
        $this->repository->delete($command->getCategoryId(), $command->getUserId());
    }

    public function updateCategory(UpdateCategoryCommand $command): void
    {
        $category = $this->repository->fetchById($command->getCategoryId(), $command->getUserId());

        $category->update($command->getCategoryName(), $command->getCategoryType(), $command->getCategoryIcon());

        $this->repository->save($category);
    }
}
