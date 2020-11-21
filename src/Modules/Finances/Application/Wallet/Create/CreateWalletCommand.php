<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet\Create;

final class CreateWalletCommand
{
    private string $name;
    private int $startBalance;

    public function __construct(string $name, int $startBalance)
    {
        $this->name = $name;
        $this->startBalance = $startBalance;
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
