<?php
declare(strict_types=1);

namespace App\Web\API\ViewModel\Finances\Wallet;

use DateTimeInterface;

final class Wallet implements \JsonSerializable
{
    private int $id;
    private string $name;
    private int $startBalance;
    private int $userId;
    private DateTimeInterface $createdAt;

    public function __construct(
        int $id,
        string $name,
        int $startBalance,
        int $userId,
        DateTimeInterface $createdAt
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->startBalance = $startBalance;
        $this->userId = $userId;
        $this->createdAt = $createdAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStartBalance(): int
    {
        return $this->startBalance;
    }

    public function getUserIds(): array
    {
        return $this->userIds;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'start_balance' => $this->getStartBalance(),
            'user_ids' => $this->getUserIds(),
            'created_at' => $this->getCreatedAt()->getTimestamp(),
        ];
    }
}
