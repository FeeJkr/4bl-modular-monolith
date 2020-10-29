<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\Application\Category;

use App\Modules\Finances\Application\Category\CategoryContract;
use App\Modules\Finances\Application\Category\Create\CreateCategoryCommand;
use App\Modules\Finances\Application\Category\Delete\DeleteCategoryCommand;
use App\Modules\Finances\Application\Category\GetAll\CategoriesCollection;
use App\Modules\Finances\Application\Category\GetAll\GetAllCategoriesQuery;
use App\Modules\Finances\Application\Category\GetOneById\CategoryDTO;
use App\Modules\Finances\Application\Category\GetOneById\GetOneCategoryByIdQuery;
use App\Modules\Finances\Application\Category\Update\UpdateCategoryCommand;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class MessageBusCategoryService implements CategoryContract
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function createCategory(CreateCategoryCommand $command): void
    {
        $this->bus->dispatch($command);
    }

    public function deleteCategory(DeleteCategoryCommand $command): void
    {
        $this->bus->dispatch($command);
    }

    public function updateCategory(UpdateCategoryCommand $command): void
    {
        $this->bus->dispatch($command);
    }

    public function getAllCategories(GetAllCategoriesQuery $query): CategoriesCollection
    {
        return $this->bus
            ->dispatch($query)
            ->last(HandledStamp::class)
            ->getResult();
    }

    public function getOneCategoryById(GetOneCategoryByIdQuery $query): CategoryDTO
    {
        return $this->bus
            ->dispatch($query)
            ->last(HandledStamp::class)
            ->getResult();
    }
}
