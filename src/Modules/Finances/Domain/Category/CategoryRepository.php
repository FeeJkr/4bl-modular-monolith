<?php
declare(strict_types=1);

namespace App\Modules\Finances\Domain\Category;

use App\Modules\Finances\Domain\User\UserId;

interface CategoryRepository
{
    public function store(Category $category): void;
    public function save(Category $category): void;
    public function delete(CategoryId $categoryId, UserId $userId): void;
    public function fetchById(CategoryId $categoryId, UserId $userId): Category;
    public function fetchAll(UserId $userId): array;
    public function fetchAllGroupedByType(UserId $userId): array;
}
