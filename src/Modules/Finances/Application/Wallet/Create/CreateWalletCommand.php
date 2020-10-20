<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet\Create;

final class CreateWalletCommand
{
    private string $name;
    private int $startBalance;
    private int $userId;

    public function __construct(string $name, int $startBalance, int $userId)
    {
        $this->name = $name;
        $this->startBalance = $startBalance;
        $this->userId = $userId;
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
}
