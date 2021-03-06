<?php
declare(strict_types=1);

namespace App\Web\MVC\Presenter\Finances\Category;

use App\Modules\Finances\Application\Category\GetAllGroupedByType\CategoryDTO;
use App\Modules\Finances\Application\Category\GetAllGroupedByType\GroupedByTypeCategoriesCollection;
use function array_map;

final class GroupedByTypeCategoriesCollectionPresenter
{
    public static function present(GroupedByTypeCategoriesCollection $collection): array
    {
        return array_map(
            static fn (array $categories): array => array_map(
                static fn(CategoryDTO $category): array => [
                    'id' => $category->getId(),
                    'name' => $category->getName(),
                    'icon' => $category->getIcon()
                ],
                $categories
            ),
            $collection->all()
        );
    }
}
