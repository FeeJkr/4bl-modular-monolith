<?php
declare(strict_types=1);

namespace App\Category\Application;

use App\Category\Application\Command\CreateNewCategoryCommand;
use App\Category\Application\Command\DeleteCategoryCommand;
use App\Category\Application\Command\UpdateCategoryCommand;
use App\Category\Domain\Category;
use App\Category\Domain\CategoryRepository;

final class CategoryService
{
    private $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createNewCategory(CreateNewCategoryCommand $command): void
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
