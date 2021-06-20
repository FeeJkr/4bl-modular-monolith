<?php

declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\Delete;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Finances\Domain\Category\CategoryId;
use App\Modules\Finances\Domain\Category\CategoryRepository;

final class DeleteCategoryHandler implements CommandHandler
{
    public function __construct(private CategoryRepository $repository){}

    public function __invoke(DeleteCategoryCommand $command): void
    {
        $id = CategoryId::fromString($command->getId());
        $category = $this->repository->getById($id);

        $this->repository->delete($category);
    }
}