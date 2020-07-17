<?php
declare(strict_types=1);

namespace App\ReadModel\Wallet;

use App\SharedKernel\User\UserId;
use Doctrine\Common\Collections\ArrayCollection;

interface WalletReadModelRepository
{
    public function fetchAll(UserId $userId): ArrayCollection;
}
