<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Transaction;

use App\Modules\Finances\Domain\Transaction\TransactionId;
use App\Modules\Finances\Domain\Wallet\WalletId;
use App\SharedKernel\User\UserId;
use Doctrine\Common\Collections\Collection;

interface TransactionReadModelRepository
{
    public function fetchAllByWallet(WalletId $walletId, UserId $userId): Collection;
    public function fetchOneById(TransactionId $transactionId, UserId $userId): TransactionDTO;
    public function fetchAll(UserId $userId): Collection;
}
