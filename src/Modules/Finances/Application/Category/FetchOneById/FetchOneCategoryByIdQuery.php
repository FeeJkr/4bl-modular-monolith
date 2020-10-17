<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\FetchOneById;

final class FetchOneCategoryByIdQuery
{
    private int $userId;
    private int $categoryId;

    public function __construct(int $userId, int $categoryId)
    {
        $this->userId = $userId;
        $this->categoryId = $categoryId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }
}
