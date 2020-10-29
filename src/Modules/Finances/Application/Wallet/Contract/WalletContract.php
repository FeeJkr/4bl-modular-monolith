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

interface WalletContract
{
    public function createWallet(CreateWalletCommand $command): void;
    public function deleteWallet(DeleteWalletCommand $command): void;
    public function updateWallet(UpdateWalletCommand $command): void;

    public function getAllWallets(GetAllWalletsQuery $query): WalletsCollection;
    public function getWalletById(GetOneWalletByIdQuery $query): WalletDTO;
}
