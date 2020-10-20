<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet\Delete;

final class DeleteWalletCommand
{
    private int $walletId;
    private int $userId;

    public function __construct(int $walletId, int $userId)
    {
        $this->walletId = $walletId;
        $this->userId = $userId;
    }

    public function getWalletId(): int
    {
        return $this->walletId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
