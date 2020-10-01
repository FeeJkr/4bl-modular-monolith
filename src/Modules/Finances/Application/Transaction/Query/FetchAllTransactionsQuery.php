<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Transaction\Query;

use App\Common\User\UserId;

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
