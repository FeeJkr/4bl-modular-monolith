<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\Query;

use App\Modules\Finances\Domain\Category\CategoryId;
use App\SharedKernel\User\UserId;

final class FetchOneCategoryByIdQuery
{
    private UserId $userId;
    private CategoryId $categoryId;

    public function __construct(UserId $userId, CategoryId $categoryId)
    {
        $this->userId = $userId;
        $this->categoryId = $categoryId;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getCategoryId(): CategoryId
    {
        return $this->categoryId;
    }
}
