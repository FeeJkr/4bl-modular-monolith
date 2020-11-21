<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet\Update;

final class UpdateWalletCommand
{
    private int $walletId;
    private string $name;
    private int $startBalance;

    public function __construct(
        int $walletId,
        string $name,
        int $startBalance
    ) {
        $this->walletId = $walletId;
        $this->name = $name;
        $this->startBalance = $startBalance;
    }

    public function getWalletId(): int
    {
        return $this->walletId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStartBalance(): int
    {
        return $this->startBalance;
    }
}
