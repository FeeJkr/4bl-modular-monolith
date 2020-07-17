<?php
declare(strict_types=1);

namespace App\Application\Wallet;

use App\Application\Wallet\Command\CreateNewWalletCommand;
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
}
