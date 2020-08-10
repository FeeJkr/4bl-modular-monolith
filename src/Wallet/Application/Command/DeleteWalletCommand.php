<?php
declare(strict_types=1);

namespace App\Wallet\Application\Command;

use App\SharedKernel\User\UserId;
use App\Wallet\SharedKernel\WalletId;

final class DeleteWalletCommand
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
