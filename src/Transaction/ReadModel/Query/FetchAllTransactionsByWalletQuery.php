<?php
declare(strict_types=1);

namespace App\Transaction\ReadModel\Query;

use App\SharedKernel\User\UserId;
use App\Wallet\SharedKernel\WalletId;

final class FetchAllTransactionsByWalletQuery
{
    private WalletId $walletId;
    private UserId $userId;

    public function __construct(WalletId $walletId, UserId $userId)
    {
        $this->walletId = $walletId;
        $this->userId = $userId;
    }

    public function getWalletId(): WalletId
    {
        return $this->walletId;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }
}
