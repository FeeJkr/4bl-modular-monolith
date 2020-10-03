<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet\Update;

use App\Common\User\UserId;
use App\Modules\Finances\Domain\Money;
use App\Modules\Finances\Domain\Wallet\WalletId;
use Doctrine\Common\Collections\Collection;

final class UpdateWalletCommand
{
    private WalletId $walletId;
    private UserId $userId;
    private string $name;
    private Money $startBalance;
    private Collection $userIds;

    public function __construct(
        WalletId $walletId,
        UserId $userId,
        string $name,
        Money $startBalance,
        Collection $userIds
    ) {
        $this->walletId = $walletId;
        $this->userId = $userId;
        $this->name = $name;
        $this->startBalance = $startBalance;
        $this->userIds = $userIds;
    }

    public function getWalletId(): WalletId
    {
        return $this->walletId;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStartBalance(): Money
    {
        return $this->startBalance;
    }

    public function getUserIds(): Collection
    {
        return $this->userIds;
    }
}
