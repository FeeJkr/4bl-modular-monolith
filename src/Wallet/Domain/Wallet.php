<?php
declare(strict_types=1);

namespace App\Wallet\Domain;

use App\SharedKernel\Money;
use App\SharedKernel\User\UserId;
use App\Wallet\SharedKernel\WalletId;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

final class Wallet
{
    private $id;
    private $name;
    private $startBalance;
    private $userIds;

    public function __construct(
        WalletId $id,
        string $name,
        Money $startBalance,
        Collection $userIds
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->startBalance = $startBalance;
        $this->userIds = $userIds;
    }

    public static function createNew(string $name, Money $startBalance, UserId $userId): self
    {
        return new self(
            WalletId::nullInstance(),
            $name,
            $startBalance,
            new ArrayCollection([$userId])
        );
    }

    public function update(string $name, Money $startBalance, Collection $userIds): void
    {
        if ($this->name !== $name) {
            $this->name = $name;
        }

        if (! $this->startBalance->equals($startBalance)) {
            $this->startBalance = $startBalance;
        }

        $oldUserIds = $this->userIds->map(static function (UserId $id): int { return $id->toInt(); })->getValues();
        $newUserIds = $userIds->map(static function (UserId $id): int { return $id->toInt(); })->getValues();
        sort($oldUserIds);
        sort($newUserIds);

        if ($newUserIds !== $oldUserIds) {
            $this->userIds = $userIds;
        }
    }

    public function getId(): WalletId
    {
        return $this->id;
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
