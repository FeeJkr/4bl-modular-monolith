<?php
declare(strict_types=1);

namespace App\Category\Domain;

use App\Category\SharedKernel\CategoryId;
use App\SharedKernel\User\UserId;

interface CategoryRepository
{
    public function store(Category $category): void;
    public function delete(CategoryId $categoryId, UserId $userId): void;
    public function fetchById(CategoryId $categoryId, UserId $userId): Category;
    public function save(Category $category): void;
}
