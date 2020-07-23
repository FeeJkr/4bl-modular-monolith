<?php
declare(strict_types=1);

namespace App\Transaction\ReadModel;

use App\SharedKernel\User\UserId;
use App\Transaction\SharedKernel\TransactionId;
use App\Wallet\SharedKernel\WalletId;
use Doctrine\Common\Collections\Collection;

interface TransactionReadModelRepository
{
    public function fetchAllByWallet(WalletId $walletId, UserId $userId): Collection;
    public function fetchOneById(TransactionId $transactionId, UserId $userId): TransactionDTO;
    public function fetchAll(UserId $userId): Collection;
}
