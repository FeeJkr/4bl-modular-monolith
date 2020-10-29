<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet\GetAll;

use DateTimeInterface;

final class WalletDTO
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

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }
}