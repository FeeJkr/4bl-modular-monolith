<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet;

use App\Modules\Finances\Application\Wallet\Command\CreateWalletCommand;
use App\Modules\Finances\Application\Wallet\Command\DeleteWalletCommand;
use App\Modules\Finances\Application\Wallet\Command\UpdateWalletCommand;
use App\Modules\Finances\Application\Wallet\Query\FetchAllWalletsQuery;
use App\Modules\Finances\Application\Wallet\Query\FetchOneWalletByIdQuery;
use App\Modules\Finances\Domain\Wallet\Wallet;
use App\Modules\Finances\Domain\Wallet\WalletRepository;
use Doctrine\Common\Collections\ArrayCollection;

final class WalletService
{
    private WalletRepository $repository;

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

    public function fetchAll(FetchAllWalletsQuery $query): ArrayCollection
    {
        return $this->repository->fetchAll($query->getUserId());
    }

    public function fetchOneById(FetchOneWalletByIdQuery $query): WalletDTO
    {
        $walletDTO = $this->repository->fetchOneById($query->getWalletId(), $query->getUserId());

        if ($walletDTO === null) {
            throw WalletReadModelException::notFound($query->getWalletId(), $query->getUserId());
        }

        return $walletDTO;
    }
}
