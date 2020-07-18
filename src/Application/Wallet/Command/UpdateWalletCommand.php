<?php
declare(strict_types=1);

namespace App\Application\Wallet\Command;

use App\SharedKernel\Money;
use App\SharedKernel\User\UserId;
use App\SharedKernel\Wallet\WalletId;
use Doctrine\Common\Collections\Collection;

final class UpdateWalletCommand
{
    private $walletId;
    private $userId;
    private $name;
    private $startBalance;
    private $userIds;

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
