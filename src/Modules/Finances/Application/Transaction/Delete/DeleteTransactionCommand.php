<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Transaction\Delete;

final class DeleteTransactionCommand
{
    private int $transactionId;

    public function __construct(int $transactionId)
    {
        $this->transactionId = $transactionId;
    }

    public function getTransactionId(): int
    {
        return $this->transactionId;
    }
}
