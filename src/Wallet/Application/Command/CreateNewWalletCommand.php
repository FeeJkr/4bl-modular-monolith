<?php
declare(strict_types=1);

namespace App\Wallet\Application\Command;

use App\SharedKernel\Money;
use App\SharedKernel\User\UserId;

final class CreateNewWalletCommand
{
    private $name;
    private $startBalance;
    private $userId;

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
