<?php

declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\Create;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Finances\Domain\Category\Category;
use App\Modules\Finances\Domain\Category\CategoryRepository;
use App\Modules\Finances\Domain\Category\CategoryType;

final class CreateCategoryHandler implements CommandHandler
{
    public function __construct(private CategoryRepository $repository){}

    public function __invoke(CreateCategoryCommand $command): void
    {
        $category = Category::new(
            $this->repository->nextIdentity(),
            $command->getName(),
            CategoryType::from($command->getType()),
            $command->getIcon(),
        );

        $this->repository->store($category);
    }
}