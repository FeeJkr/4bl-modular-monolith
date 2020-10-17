<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\Delete;

use App\Modules\Finances\Domain\Category\CategoryId;
use App\Modules\Finances\Domain\Category\CategoryRepository;
use App\Modules\Finances\Domain\User\UserId;

final class DeleteCategoryHandler
{
    private CategoryRepository $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(DeleteCategoryCommand $command): void
    {
        $this->repository->delete(
            CategoryId::fromInt($command->getCategoryId()),
            UserId::fromInt($command->getUserId())
        );
    }
}
