<?php
declare(strict_types=1);

namespace App\Modules\Finances\Domain\Wallet;

use App\Common\User\UserId;
use App\Modules\Finances\Application\Wallet\WalletDTO;
use Doctrine\Common\Collections\ArrayCollection;

interface WalletRepository
{
    public function store(Wallet $wallet): void;
    public function save(Wallet $wallet): void;
    public function delete(WalletId $walletId, UserId $userId): void;
    public function fetchById(WalletId $walletId, UserId $userId): Wallet;
    public function fetchAll(UserId $userId): ArrayCollection;
    public function fetchOneById(WalletId $walletId, UserId $userId): ?WalletDTO;
}
