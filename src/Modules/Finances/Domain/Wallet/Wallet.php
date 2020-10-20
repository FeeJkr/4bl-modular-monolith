<?php
declare(strict_types=1);

namespace App\Modules\Finances\Domain\Wallet;

use App\Modules\Finances\Domain\Money;
use App\Modules\Finances\Domain\User\UserId;
use DateTime;
use DateTimeInterface;

final class Wallet
{
    private WalletId $id;
    private string $name;
    private Money $startBalance;
    private UserId $userId;
    private DateTimeInterface $createdAt;

    public function __construct(
        WalletId $id,
        string $name,
        Money $startBalance,
        UserId $userId,
        DateTimeInterface $createdAt
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->startBalance = $startBalance;
        $this->userId = $userId;
        $this->createdAt = $createdAt;
    }

    public static function createNew(string $name, Money $startBalance, UserId $userId): self
    {
        return new self(
            WalletId::nullInstance(),
            $name,
            $startBalance,
            $userId,
            new DateTime()
        );
    }

    public function update(string $name, Money $startBalance, UserId $userId): void
    {
        if ($this->name !== $name) {
            $this->name = $name;
        }

        if (! $this->startBalance->equals($startBalance)) {
            $this->startBalance = $startBalance;
        }

        if ($this->userId->toInt() !== $userId->toInt()) {
            $this->userId = $userId;
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

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }
}
