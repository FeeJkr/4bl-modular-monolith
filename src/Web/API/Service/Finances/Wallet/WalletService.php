<?php
declare(strict_types=1);

namespace App\Web\API\Service\Finances\Wallet;

use App\Web\API\Request\Finances\Wallet\CreateWalletRequest;
use App\Web\API\Request\Finances\Wallet\DeleteWalletRequest;
use App\Web\API\Request\Finances\Wallet\GetAllWalletsRequest;
use App\Web\API\Request\Finances\Wallet\GetOneWalletByIdRequest;
use App\Web\API\Request\Finances\Wallet\UpdateWalletRequest;
use App\Web\API\ViewModel\Finances\Wallet\Wallet;

interface WalletService
{
    public function createWallet(CreateWalletRequest $request): void;
    public function deleteWallet(DeleteWalletRequest $request): void;
    public function getAllWallets(GetAllWalletsRequest $request): array;
    public function getOneWalletById(GetOneWalletByIdRequest $request): Wallet;
    public function updateWallet(UpdateWalletRequest $request): void;
}
