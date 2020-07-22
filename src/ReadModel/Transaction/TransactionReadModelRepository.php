<?php
declare(strict_types=1);

namespace App\ReadModel\Transaction;

use App\SharedKernel\Transaction\TransactionId;
use App\SharedKernel\User\UserId;
use App\SharedKernel\Wallet\WalletId;
use Doctrine\Common\Collections\Collection;

interface TransactionReadModelRepository
{
    public function fetchAllByWallet(WalletId $walletId, UserId $userId): Collection;
    public function fetchOneById(TransactionId $transactionId, UserId $userId): TransactionDTO;
    public function fetchAll(UserId $userId): Collection;
}
