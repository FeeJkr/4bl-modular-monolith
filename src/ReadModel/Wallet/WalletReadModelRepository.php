<?php
declare(strict_types=1);

namespace App\ReadModel\Wallet;

use App\SharedKernel\User\UserId;
use App\SharedKernel\Wallet\WalletId;
use Doctrine\Common\Collections\ArrayCollection;

interface WalletReadModelRepository
{
    public function fetchAll(UserId $userId): ArrayCollection;
    public function fetchOneById(WalletId $walletId, UserId $userId): ?WalletDTO;
}
