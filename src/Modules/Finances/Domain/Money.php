<?php
declare(strict_types=1);

namespace App\Modules\Finances\Domain;

final class Money
{
    private int $amount;

    public function __construct(int $amount)
    {
        $this->amount = $amount;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function equals(Money $money): bool
    {
        return $this->amount === $money->getAmount();
    }

    public function negate(): self
    {
        return new self(-$this->amount);
    }
}
