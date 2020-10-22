<?php
declare(strict_types=1);

namespace App\Modules\Finances\Domain\Transaction;

use App\Modules\Finances\Domain\User\UserId;
use Exception;

final class TransactionException extends Exception
{
    public static function notFound(TransactionId $transactionId, UserId $userId): self
    {
        return new self(
            sprintf('TransactionResponse with ID %s not found for user %s', $transactionId->toInt(), $userId->toInt())
        );
    }
}
