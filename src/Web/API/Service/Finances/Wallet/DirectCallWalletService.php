<?php
declare(strict_types=1);

namespace App\Web\API\Service\Finances\Wallet;

use App\Modules\Finances\Application\Wallet\Contract\WalletContract;
use App\Modules\Finances\Application\Wallet\Create\CreateWalletCommand;
use App\Modules\Finances\Application\Wallet\Delete\DeleteWalletCommand;
use App\Modules\Finances\Application\Wallet\GetAll\GetAllWalletsQuery;
use App\Modules\Finances\Application\Wallet\GetOneById\GetOneWalletByIdQuery;
use App\Modules\Finances\Application\Wallet\Update\UpdateWalletCommand;
use App\Web\API\Request\Finances\Wallet\CreateWalletRequest;
use App\Web\API\Request\Finances\Wallet\DeleteWalletRequest;
use App\Web\API\Request\Finances\Wallet\GetAllWalletsRequest;
use App\Web\API\Request\Finances\Wallet\GetOneWalletByIdRequest;
use App\Web\API\Request\Finances\Wallet\UpdateWalletRequest;
use App\Web\API\Response\Finances\Wallet\WalletResponse;
use App\Web\API\Response\Finances\Wallet\WalletsResponse;
use App\Web\API\Service\Finances\User\UserService;

final class DirectCallWalletService implements WalletService
{
    private UserService $userService;
    private WalletContract $walletContract;

    public function __construct(UserService $userService, WalletContract $walletContract)
    {
        $this->userService = $userService;
        $this->walletContract = $walletContract;
    }

    public function createWallet(CreateWalletRequest $request): void
    {
        $userId = $this->userService->getUserIdByToken($request->getUserToken());
        $command = new CreateWalletCommand(
            $request->getWalletName(),
            $request->getWalletStartBalance(),
            $userId
        );

        $this->walletContract->createWallet($command);
    }

    public function deleteWallet(DeleteWalletRequest $request): void
    {
        $userId = $this->userService->getUserIdByToken($request->getUserToken());
        $command = new DeleteWalletCommand(
            $request->getWalletId(),
            $userId
        );

        $this->walletContract->deleteWallet($command);
    }

    public function updateWallet(UpdateWalletRequest $request): void
    {
        $userId = $this->userService->getUserIdByToken($request->getUserToken());
        $command = new UpdateWalletCommand(
            $request->getWalletId(),
            $userId,
            $request->getWalletName(),
            $request->getWalletStartBalance()
        );

        $this->walletContract->updateWallet($command);
    }

    public function getAllWallets(GetAllWalletsRequest $request): WalletsResponse
    {
        $query = new GetAllWalletsQuery(
            $this->userService->getUserIdByToken($request->getUserToken())
        );

        return WalletsResponse::createFromCollection(
            $this->walletContract->getAllWallets($query)
        );
    }

    public function getOneWalletById(GetOneWalletByIdRequest $request): WalletResponse
    {
        $query = new GetOneWalletByIdQuery(
            $request->getWalletId(),
            $this->userService->getUserIdByToken($request->getUserToken())
        );

        $wallet = $this->walletContract->getWalletById($query);

        return new WalletResponse(
            $wallet->getId(),
            $wallet->getName(),
            $wallet->getStartBalance(),
            $wallet->getUserId(),
            $wallet->getCreatedAt()
        );
    }
}
