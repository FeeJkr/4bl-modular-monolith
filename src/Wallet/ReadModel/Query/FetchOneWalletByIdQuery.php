<?php
declare(strict_types=1);

namespace App\Wallet\ReadModel\Query;

use App\SharedKernel\User\UserId;
use App\Wallet\SharedKernel\WalletId;

final class FetchOneWalletByIdQuery
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
