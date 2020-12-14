<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\Create;

use App\Modules\Finances\Domain\Category\Category;
use App\Modules\Finances\Domain\Category\CategoryRepository;
use App\Modules\Finances\Domain\Category\CategoryType;
use App\Modules\Finances\Domain\User\UserContext;

final class CreateCategoryHandler
{
    public function __construct(private CategoryRepository $repository, private UserContext $userContext) {}

    public function __invoke(CreateCategoryCommand $command): void
    {
        $category = Category::createNew(
            $this->userContext->getUserId(),
            $command->getName(),
            new CategoryType($command->getType()),
            $command->getIcon()
        );

        $this->repository->store($category);
    }
}
