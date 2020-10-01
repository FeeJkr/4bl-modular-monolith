<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet;

use App\Common\User\UserId;
use App\Modules\Finances\Domain\Wallet\WalletId;
use Doctrine\Common\Collections\ArrayCollection;

interface WalletReadModelRepository
{
    public function fetchAll(UserId $userId): ArrayCollection;
    public function fetchOneById(WalletId $walletId, UserId $userId): ?WalletDTO;
}
