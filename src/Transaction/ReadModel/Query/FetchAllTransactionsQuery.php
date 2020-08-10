<?php
declare(strict_types=1);

namespace App\Transaction\ReadModel\Query;

use App\SharedKernel\User\UserId;

final class FetchAllTransactionsQuery
{
    private Userid $userId;

    public function __construct(UserId $userId)
    {
        $this->userId = $userId;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }
}
