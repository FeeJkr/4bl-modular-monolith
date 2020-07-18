<?php
declare(strict_types=1);

namespace App\DomainModel\Wallet;

use App\SharedKernel\User\UserId;
use App\SharedKernel\Wallet\WalletId;

interface WalletRepository
{
    public function store(Wallet $wallet): void;
    public function delete(WalletId $walletId, UserId $userId): void;
    public function fetchById(WalletId $walletId, UserId $userId): Wallet;
    public function save(Wallet $wallet): void;
}
