<?php
declare(strict_types=1);

namespace App\Application\Category\Command;

use App\SharedKernel\Category\CategoryId;
use App\SharedKernel\User\UserId;

final class DeleteCategoryCommand
{
    private $categoryId;
    private $userId;

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
