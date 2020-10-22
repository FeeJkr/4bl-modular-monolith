<?php
declare(strict_types=1);

namespace App\Web\API\Service\Finances\Wallet;

use App\Web\API\Request\Finances\Wallet\CreateWalletRequest;
use App\Web\API\Request\Finances\Wallet\DeleteWalletRequest;
use App\Web\API\Request\Finances\Wallet\GetAllWalletsRequest;
use App\Web\API\Request\Finances\Wallet\GetOneWalletByIdRequest;
use App\Web\API\Request\Finances\Wallet\UpdateWalletRequest;
use App\Web\API\Response\Finances\Wallet\WalletResponse;
use App\Web\API\Response\Finances\Wallet\WalletsResponse;

interface WalletService
{
    public function createWallet(CreateWalletRequest $request): void;
    public function deleteWallet(DeleteWalletRequest $request): void;
    public function getAllWallets(GetAllWalletsRequest $request): WalletsResponse;
    public function getOneWalletById(GetOneWalletByIdRequest $request): WalletResponse;
    public function updateWallet(UpdateWalletRequest $request): void;
}
