<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet;

use App\Common\User\UserId;
use App\Modules\Finances\Domain\Money;
use App\Modules\Finances\Domain\Wallet\WalletId;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JsonSerializable;

final class WalletDTO implements JsonSerializable
{
    private WalletId $id;
    private string $name;
    private Money $startBalance;
    private Collection $userIds;
    private DateTimeInterface $createdAt;

    public function __construct(
        WalletId $id,
        string $name,
        Money $startBalance,
        Collection $userIds,
        DateTimeInterface $createdAt
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->startBalance = $startBalance;
        $this->userIds = $userIds;
        $this->createdAt = $createdAt;
    }

    public static function createFromArray(array $wallet): self
    {
        $userIds = (new ArrayCollection(explode(', ', $wallet['user_ids'])))
            ->map(static function (string $id): UserId {
                return UserId::fromInt((int) $id);
            });

        return new self(
            WalletId::fromInt($wallet['id']),
            $wallet['name'],
            new Money($wallet['start_balance']),
            $userIds,
            DateTime::createFromFormat('Y-m-d H:i:s', $wallet['created_at'])
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id->toInt(),
            'name' => $this->name,
            'start_balance' => $this->startBalance->getAmount(),
            'user_ids' => $this->userIds->map(static function (UserId $id): int {
                return $id->toInt();
            })->toArray(),
            'created_at' => $this->createdAt->getTimestamp(),
        ];
    }
}
