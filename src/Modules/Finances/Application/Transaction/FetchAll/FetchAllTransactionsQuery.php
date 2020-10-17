<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Transaction\FetchAll;

final class FetchAllTransactionsQuery
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
