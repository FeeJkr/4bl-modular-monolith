<?php

declare(strict_types=1);

namespace App\Modules\Finances\Application\Category;

final class CategoryDTOCollection
{
    public function __construct(private array $elements = []){}

    public function add(CategoryDTO $category): void
    {
        $this->elements[] = $category;
    }

    public function toArray(): array
    {
        return $this->elements;
    }
}