<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet\Update;

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
        $wallet = $this->repository->fetchById($command->getWalletId(), $command->getUserId());

        $wallet->update($command->getName(), $command->getStartBalance(), $command->getUserIds());

        $this->repository->save($wallet);
    }
}
