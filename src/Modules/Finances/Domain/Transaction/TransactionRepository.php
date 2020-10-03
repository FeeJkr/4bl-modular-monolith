<?php
declare(strict_types=1);

namespace App\Modules\Finances\Domain\Transaction;

use App\Common\User\UserId;
use App\Modules\Finances\Application\Transaction\FetchOneById\TransactionDTO;
use App\Modules\Finances\Domain\Wallet\WalletId;
use Doctrine\Common\Collections\Collection;

interface TransactionRepository
{
    public function store(Transaction $transaction): void;
    public function save(Transaction $transaction): void;
    public function delete(TransactionId $transactionId, UserId $userId): void;
    public function fetchById(TransactionId $transactionId, UserId $userId): Transaction;
    public function fetchAllByWallet(WalletId $walletId, UserId $userId): Collection;
    public function fetchOneById(TransactionId $transactionId, UserId $userId): TransactionDTO;
    public function fetchAll(UserId $userId): Collection;
}
