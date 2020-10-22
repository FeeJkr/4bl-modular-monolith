<?php
declare(strict_types=1);

namespace App\Web\API\Response\Finances\Wallet;

use DateTimeInterface;

final class WalletResponse
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

    public function getResponse(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'start_balance' => $this->startBalance,
            'user_ids' => $this->userId,
            'created_at' => $this->createdAt->getTimestamp(),
        ];
    }
}
