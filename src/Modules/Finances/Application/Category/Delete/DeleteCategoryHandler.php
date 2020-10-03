<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\Delete;

use App\Modules\Finances\Domain\Category\CategoryRepository;

final class DeleteCategoryHandler
{
    private CategoryRepository $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(DeleteCategoryCommand $command): void
    {
        $this->repository->delete($command->getCategoryId(), $command->getUserId());
    }
}
