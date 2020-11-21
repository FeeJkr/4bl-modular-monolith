<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\Delete;

final class DeleteCategoryCommand
{
    private int $categoryId;

    public function __construct(int $categoryId)
    {
        $this->categoryId = $categoryId;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }
}
