<?php
declare(strict_types=1);

namespace App\Wallet\Application;

use App\Wallet\Application\Command\CreateWalletCommand;
use App\Wallet\Application\Command\DeleteWalletCommand;
use App\Wallet\Application\Command\UpdateWalletCommand;
use App\Wallet\Domain\Wallet;
use App\Wallet\Domain\WalletRepository;

final class WalletService
{
    private $repository;

    public function __construct(WalletRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createNewWallet(CreateWalletCommand $command): void
    {
        $wallet = Wallet::createNew(
            $command->getName(),
            $command->getStartBalance(),
            $command->getUserId()
        );

        $this->repository->store($wallet);
    }

    public function deleteWallet(DeleteWalletCommand $command): void
    {
        $this->repository->delete($command->getWalletId(), $command->getUserId());
    }

    public function updateWallet(UpdateWalletCommand $command): void
    {
        $wallet = $this->repository->fetchById($command->getWalletId(), $command->getUserId());

        $wallet->update($command->getName(), $command->getStartBalance(), $command->getUserIds());

        $this->repository->save($wallet);
    }
}
