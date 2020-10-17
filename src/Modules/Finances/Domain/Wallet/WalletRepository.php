<?php
declare(strict_types=1);

namespace App\Modules\Finances\Domain\Wallet;

use App\Modules\Finances\Domain\User\UserId;

interface WalletRepository
{
    public function store(Wallet $wallet): void;
    public function save(Wallet $wallet): void;
    public function delete(WalletId $walletId, UserId $userId): void;
    public function fetchById(WalletId $walletId, UserId $userId): Wallet;
    public function fetchAll(UserId $userId): array;
}
