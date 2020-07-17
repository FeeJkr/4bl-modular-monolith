<?php
declare(strict_types=1);

namespace App\DomainModel\Category;

interface CategoryRepository
{
    public function store(Category $category): void;
}
