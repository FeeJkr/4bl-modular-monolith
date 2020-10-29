<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet\Contract;

use App\Modules\Finances\Application\Wallet\Create\CreateWalletCommand;
use App\Modules\Finances\Application\Wallet\Delete\DeleteWalletCommand;
use App\Modules\Finances\Application\Wallet\GetAll\GetAllWalletsQuery;
use App\Modules\Finances\Application\Wallet\GetAll\WalletsCollection;
use App\Modules\Finances\Application\Wallet\GetOneById\GetOneWalletByIdQuery;
use App\Modules\Finances\Application\Wallet\GetOneById\WalletDTO;
use App\Modules\Finances\Application\Wallet\Update\UpdateWalletCommand;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class WalletService implements WalletContract
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function createWallet(CreateWalletCommand $command): void
    {
        $this->bus->dispatch($command);
    }

    public function deleteWallet(DeleteWalletCommand $command): void
    {
        $this->bus->dispatch($command);
    }

    public function updateWallet(UpdateWalletCommand $command): void
    {
        $this->bus->dispatch($command);
    }

    public function getAllWallets(GetAllWalletsQuery $query): WalletsCollection
    {
        return $this->bus
            ->dispatch($query)
            ->last(HandledStamp::class)
            ->getResult();
    }

    public function getWalletById(GetOneWalletByIdQuery $query): WalletDTO
    {
        return $this->bus
            ->dispatch($query)
            ->last(HandledStamp::class)
            ->getResult();
    }
}
