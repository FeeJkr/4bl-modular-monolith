<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\Delete;

final class DeleteCategoryCommand
{
    public function __construct(private int $categoryId) {}

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }
}
