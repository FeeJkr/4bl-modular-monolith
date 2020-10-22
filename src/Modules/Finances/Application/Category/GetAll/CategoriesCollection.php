<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\GetAll;

final class CategoriesCollection
{
    /** @var CategoryDTO[] $categories */
    private array $categories;

    public function __construct(array $categories)
    {
        $this->categories = $categories;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }
}
