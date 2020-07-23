<?php
declare(strict_types=1);

namespace App\Wallet\ReadModel\Query;

use App\SharedKernel\User\UserId;

final class FetchAllWalletsQuery
{
    private $userId;

    public function __construct(UserId $userId)
    {
        $this->userId = $userId;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }
}