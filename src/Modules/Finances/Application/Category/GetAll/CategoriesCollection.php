<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\GetAll;

final class CategoriesCollection
{
    public function __construct(private array $categories) {}

    public function getCategories(): array
    {
        return $this->categories;
    }
}
