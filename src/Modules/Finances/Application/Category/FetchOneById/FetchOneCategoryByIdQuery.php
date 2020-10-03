<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\FetchOneById;

use App\Modules\Finances\Domain\Category\CategoryId;
use App\Modules\Finances\Domain\User\UserId;

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
