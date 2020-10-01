<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\Command;

use App\Common\User\UserId;
use App\Modules\Finances\Domain\Category\CategoryId;

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
