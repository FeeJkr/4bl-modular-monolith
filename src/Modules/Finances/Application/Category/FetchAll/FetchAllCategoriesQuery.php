<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\FetchAll;

use App\Modules\Finances\Domain\User\UserId;

final class FetchAllCategoriesQuery
{
    private UserId $userId;

    public function __construct(UserId $userId)
    {
        $this->userId = $userId;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }
}
