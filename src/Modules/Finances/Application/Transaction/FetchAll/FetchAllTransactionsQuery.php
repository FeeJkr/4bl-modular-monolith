<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Transaction\FetchAll;

use App\Modules\Finances\Domain\User\UserId;

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
