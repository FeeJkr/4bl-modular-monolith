<?php
declare(strict_types=1);

namespace App\Web\API\Response\Finances\Category;

use App\Modules\Finances\Application\Category\GetAll\CategoriesCollection;

final class CategoriesResponse
{
    /** @var CategoryResponse[] */
    private array $categories;

    public function __construct(array $categories)
    {
        $this->categories = $categories;
    }

    public static function createFromCollection(CategoriesCollection $collection): self
    {
        $data = [];

        foreach ($collection->getCategories() as $category) {
            $data[] = new CategoryResponse(
                $category->getId(),
                $category->getUserId(),
                $category->getName(),
                $category->getType(),
                $category->getIcon(),
                $category->getCreatedAt()
            );
        }

        return new self($data);
    }

    public function getResponse(): array
    {
        return array_map(
            static fn(CategoryResponse $category) => $category->getResponse(),
            $this->categories
        );
    }
}
