<?php
declare(strict_types=1);

namespace App\Modules\Finances\Domain\Transaction;

use App\Modules\Finances\Domain\User\UserId;
use App\Modules\Finances\Domain\Wallet\WalletId;

interface TransactionRepository
{
    public function store(Transaction $transaction): void;
    public function save(Transaction $transaction): void;
    public function delete(TransactionId $transactionId, UserId $userId): void;
    public function fetchById(TransactionId $transactionId, UserId $userId): Transaction;
    public function fetchAllByWallet(WalletId $walletId, UserId $userId): array;
    public function fetchAll(UserId $userId): array;
}
