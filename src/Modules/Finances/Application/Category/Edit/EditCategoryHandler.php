<?php

declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\Edit;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Finances\Domain\Category\CategoryId;
use App\Modules\Finances\Domain\Category\CategoryRepository;
use App\Modules\Finances\Domain\Category\CategoryType;
use App\Modules\Finances\Domain\User\UserContext;

final class EditCategoryHandler implements CommandHandler
{
    public function __construct(private CategoryRepository $repository, private UserContext $userContext){}

    public function __invoke(EditCategoryCommand $command): void
    {
        $category = $this->repository->getById(
            CategoryId::fromString($command->getId()),
            $this->userContext->getUserId()
        );

        $category->update(
            $command->getName(),
            CategoryType::from($command->getType()),
            $command->getIcon(),
        );

        $this->repository->save($category);
    }
}