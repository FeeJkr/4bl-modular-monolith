<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\Delete;

use App\Modules\Finances\Domain\Category\CategoryId;
use App\Modules\Finances\Domain\Category\CategoryRepository;
use App\Modules\Finances\Domain\User\UserContext;

final class DeleteCategoryHandler
{
    public function __construct(private CategoryRepository $repository, private UserContext $userContext) {}

    public function __invoke(DeleteCategoryCommand $command): void
    {
        $this->repository->delete(
            CategoryId::fromInt($command->getCategoryId()),
            $this->userContext->getUserId()
        );
    }
}
