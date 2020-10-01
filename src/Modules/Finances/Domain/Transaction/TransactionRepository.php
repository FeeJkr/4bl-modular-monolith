<?php
declare(strict_types=1);

namespace App\Modules\Finances\Domain\Transaction;

use App\SharedKernel\User\UserId;

interface TransactionRepository
{
    public function store(Transaction $transaction): void;
    public function delete(TransactionId $transactionId, UserId $userId): void;
    public function save(Transaction $transaction): void;
    public function fetchById(TransactionId $transactionId, UserId $userId): Transaction;
}
