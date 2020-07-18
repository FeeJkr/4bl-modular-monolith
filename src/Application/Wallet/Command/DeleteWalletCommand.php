<?php
declare(strict_types=1);

namespace App\Application\Wallet\Command;

use App\SharedKernel\User\UserId;
use App\SharedKernel\Wallet\WalletId;

final class DeleteWalletCommand
{
    private $walletId;
    private $userId;

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
