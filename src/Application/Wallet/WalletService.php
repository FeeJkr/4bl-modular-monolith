<?php
declare(strict_types=1);

namespace App\Application\Wallet;

use App\Application\Wallet\Command\CreateNewWalletCommand;
use App\Application\Wallet\Command\DeleteWalletCommand;
use App\Application\Wallet\Command\UpdateWalletCommand;
use App\DomainModel\Wallet\Wallet;
use App\DomainModel\Wallet\WalletRepository;

final class WalletService
{
    private $repository;

    public function __construct(WalletRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createNewWallet(CreateNewWalletCommand $command): void
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
