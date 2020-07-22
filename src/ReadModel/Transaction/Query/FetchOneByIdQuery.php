<?php
declare(strict_types=1);

namespace App\ReadModel\Transaction\Query;

use App\SharedKernel\Transaction\TransactionId;
use App\SharedKernel\User\UserId;

final class FetchOneByIdQuery
{
    private $transactionId;
    private $userId;

    public function __construct(TransactionId $transactionId, UserId $userId)
    {
        $this->transactionId = $transactionId;
        $this->userId = $userId;
    }

    public function getTransactionId(): TransactionId
    {
        return $this->transactionId;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }
}
