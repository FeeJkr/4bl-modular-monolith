<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet\Update;

use App\Modules\Finances\Domain\Money;
use App\Modules\Finances\Domain\User\UserId;
use App\Modules\Finances\Domain\Wallet\WalletId;
use App\Modules\Finances\Domain\Wallet\WalletRepository;

final class UpdateWalletHandler
{
    private WalletRepository $repository;

    public function __construct(WalletRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(UpdateWalletCommand $command): void
    {
        $walletId = WalletId::fromInt($command->getWalletId());
        $userId = UserId::fromInt($command->getUserId());
        $startBalance = new Money($command->getStartBalance());

        $wallet = $this->repository->fetchById($walletId, $userId);

        $wallet->update($command->getName(), $startBalance, $userId);

        $this->repository->save($wallet);
    }
}
