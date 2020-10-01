<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet\Query;

use App\Common\User\UserId;
use App\Modules\Finances\Domain\Wallet\WalletId;

final class FetchOneWalletByIdQuery
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
