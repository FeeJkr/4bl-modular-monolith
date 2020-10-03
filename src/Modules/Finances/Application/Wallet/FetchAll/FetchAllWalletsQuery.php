<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet\FetchAll;

use App\Common\User\UserId;

final class FetchAllWalletsQuery
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
