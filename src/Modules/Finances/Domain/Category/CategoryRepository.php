<?php

declare(strict_types=1);

namespace App\Modules\Finances\Domain\Category;

interface CategoryRepository
{
    public function store(Category $category): void;
    public function nextIdentity(): CategoryId;
    public function getById(CategoryId $id): Category;
    public function delete(Category $category): void;
    public function save(Category $category): void;
}