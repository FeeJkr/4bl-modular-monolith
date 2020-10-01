<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Transaction;

use App\Common\User\UserId;
use App\Modules\Finances\Domain\Transaction\TransactionId;
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
