<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet\Command;

use App\Modules\Finances\Domain\Wallet\WalletId;
use App\SharedKernel\User\UserId;

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
