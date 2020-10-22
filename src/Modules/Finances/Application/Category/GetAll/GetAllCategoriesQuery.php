<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\GetAll;

final class GetAllCategoriesQuery
{
    private int $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
