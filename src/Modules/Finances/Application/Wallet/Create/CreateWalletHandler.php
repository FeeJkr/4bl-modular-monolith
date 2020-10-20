<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet\Create;

use App\Modules\Finances\Domain\Money;
use App\Modules\Finances\Domain\User\UserId;
use App\Modules\Finances\Domain\Wallet\Wallet;
use App\Modules\Finances\Domain\Wallet\WalletRepository;

final class CreateWalletHandler
{
    private WalletRepository $repository;

    public function __construct(WalletRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(CreateWalletCommand $command): void
    {
        $userId = UserId::fromInt($command->getUserId());
        $startBalance = new Money($command->getStartBalance());

        $wallet = Wallet::createNew(
            $command->getName(),
            $startBalance,
            $userId
        );

        $this->repository->store($wallet);
    }
}
