<?php
declare(strict_types=1);

namespace App\Application\Category;

use App\Application\Category\Command\CreateNewCategoryCommand;
use App\Application\Category\Command\DeleteCategoryCommand;
use App\DomainModel\Category\Category;
use App\DomainModel\Category\CategoryRepository;

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
}
