<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Transaction\Command;

use App\Modules\Finances\Domain\Transaction\TransactionId;
use App\SharedKernel\User\UserId;

final class DeleteTransactionCommand
{
    private TransactionId $transactionId;
    private UserId $userId;

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
