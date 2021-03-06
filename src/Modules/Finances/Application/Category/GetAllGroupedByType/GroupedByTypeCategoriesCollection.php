<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\GetAllGroupedByType;

final class GroupedByTypeCategoriesCollection
{
    public function __construct(private array $elements) {}

    public function all(): array
    {
        return $this->elements;
    }
}
