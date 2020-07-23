<?php
declare(strict_types=1);

namespace App\Transaction\Domain;

use App\SharedKernel\User\UserId;
use App\Transaction\SharedKernel\TransactionId;
use Exception;

final class TransactionException extends Exception
{
    public static function notFound(TransactionId $transactionId, UserId $userId): self
    {
        return new self(
            sprintf('Transaction with ID %s not found for user %s', $transactionId->toInt(), $userId->toInt())
        );
    }
}
