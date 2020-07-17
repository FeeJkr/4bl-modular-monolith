<?php
declare(strict_types=1);

namespace App\ReadModel\Category\Query;

use App\SharedKernel\Category\CategoryId;
use App\SharedKernel\User\UserId;

final class FetchOneByIdQuery
{
    private $userId;
    private $categoryId;

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
