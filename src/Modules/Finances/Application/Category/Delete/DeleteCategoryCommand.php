<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\Delete;

final class DeleteCategoryCommand
{
    private int $categoryId;
    private int $userId;

    public function __construct(int $categoryId, int $userId)
    {
        $this->categoryId = $categoryId;
        $this->userId = $userId;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
