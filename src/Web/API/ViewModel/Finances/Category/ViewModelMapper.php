<?php
declare(strict_types=1);

namespace App\Web\API\ViewModel\Finances\Category;

use App\Modules\Finances\Application\Category\FetchAll\CategoriesCollection;
use App\Modules\Finances\Application\Category\FetchOneById\CategoryDTO;

final class ViewModelMapper
{
    public function map(CategoryDTO $dto): Category
    {
        return new Category(
            $dto->getId(),
            $dto->getUserId(),
            $dto->getName(),
            $dto->getType(),
            $dto->getIcon(),
            $dto->getCreatedAt()
        );
    }

    public function mapCollection(CategoriesCollection $categoriesCollection): array
    {
        $categories = [];

        /** @var \App\Modules\Finances\Application\Category\FetchAll\CategoryDTO $category */
        foreach ($categoriesCollection->getCategories() as $category) {
            $categories[] = new Category(
                $category->getId(),
                $category->getUserId(),
                $category->getName(),
                $category->getType(),
                $category->getIcon(),
                $category->getCreatedAt()
            );
        }

        return $categories;
    }
}
