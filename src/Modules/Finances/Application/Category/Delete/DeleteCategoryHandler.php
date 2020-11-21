<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\Delete;

use App\Modules\Finances\Domain\Category\CategoryId;
use App\Modules\Finances\Domain\Category\CategoryRepository;
use App\Modules\Finances\Domain\User\UserContext;
use App\Modules\Finances\Domain\User\UserId;

final class DeleteCategoryHandler
{
    private CategoryRepository $repository;
    private UserContext $userContext;

    public function __construct(CategoryRepository $repository, UserContext $userContext)
    {
        $this->repository = $repository;
        $this->userContext = $userContext;
    }

    public function __invoke(DeleteCategoryCommand $command): void
    {
        $this->repository->delete(
            CategoryId::fromInt($command->getCategoryId()),
            $this->userContext->getUserId()
        );
    }
}
