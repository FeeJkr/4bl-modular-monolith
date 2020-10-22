<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Transaction\GetOneById;

final class GetOneTransactionByIdQuery
{
    private int $transactionId;
    private int $userId;

    public function __construct(int $transactionId, int $userId)
    {
        $this->transactionId = $transactionId;
        $this->userId = $userId;
    }

    public function getTransactionId(): int
    {
        return $this->transactionId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
