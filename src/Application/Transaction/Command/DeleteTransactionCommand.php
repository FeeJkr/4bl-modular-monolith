<?php
declare(strict_types=1);

namespace App\Application\Transaction\Command;

use App\SharedKernel\Transaction\TransactionId;
use App\SharedKernel\User\UserId;

final class DeleteTransactionCommand
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
