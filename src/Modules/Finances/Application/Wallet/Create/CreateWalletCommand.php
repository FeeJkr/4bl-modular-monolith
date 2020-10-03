<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet\Create;

use App\Modules\Finances\Domain\Money;
use App\Modules\Finances\Domain\User\UserId;

final class CreateWalletCommand
{
    private string $name;
    private Money $startBalance;
    private UserId $userId;

    public function __construct(string $name, Money $startBalance, UserId $userId)
    {
        $this->name = $name;
        $this->startBalance = $startBalance;
        $this->userId = $userId;
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
}
