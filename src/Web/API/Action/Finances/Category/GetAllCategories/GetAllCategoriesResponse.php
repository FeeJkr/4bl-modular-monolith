<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Category\GetAllCategories;

use App\Modules\Finances\Application\Category\GetAll\CategoriesCollection;

final class GetAllCategoriesResponse
{
    private array $categories;

    public function __construct(array ...$categories)
    {
        $this->categories = $categories;
    }

    public static function createFromCollection(CategoriesCollection $collection): self
    {
        $data = [];

        foreach ($collection->getCategories() as $category) {
            $data[] = [
                'id' => $category->getId(),
                'userId' => $category->getUserId(),
                'name' => $category->getName(),
                'type' => $category->getType(),
                'icon' => $category->getIcon(),
                'createdAt' => $category->getCreatedAt()
            ];
        }

        return new self(...$data);
    }

    public function getResponse(): array
    {
        return $this->categories;
    }
}
