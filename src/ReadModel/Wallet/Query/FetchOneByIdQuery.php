<?php
declare(strict_types=1);

namespace App\ReadModel\Wallet\Query;

use App\SharedKernel\User\UserId;
use App\SharedKernel\Wallet\WalletId;

final class FetchOneByIdQuery
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
