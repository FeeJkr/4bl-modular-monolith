<?php
declare(strict_types=1);

namespace App\Category\Application\Command;

use App\Category\SharedKernel\CategoryId;
use App\SharedKernel\User\UserId;

final class DeleteCategoryCommand
{
    private CategoryId $categoryId;
    private UserId $userId;

    public function __construct(CategoryId $categoryId, UserId $userId)
    {
        $this->categoryId = $categoryId;
        $this->userId = $userId;
    }

    public function getCategoryId(): CategoryId
    {
        return $this->categoryId;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }
}
