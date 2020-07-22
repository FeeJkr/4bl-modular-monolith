<?php
declare(strict_types=1);

namespace App\ReadModel\Transaction;

use App\SharedKernel\Transaction\TransactionId;
use App\SharedKernel\User\UserId;
use Exception;

final class TransactionReadModelException extends Exception
{
    public static function notFound(TransactionId $transactionId, UserId $userId): self
    {
        return new self(
            sprintf('Transaction with ID %s not found for user %s', $transactionId->toInt(), $userId->toInt())
        );
    }
}
