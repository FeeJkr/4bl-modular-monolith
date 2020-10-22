<?php
declare(strict_types=1);

namespace App\Web\API\Service\Finances\Wallet;

use App\Modules\Finances\Application\Wallet\Create\CreateWalletCommand;
use App\Modules\Finances\Application\Wallet\Delete\DeleteWalletCommand;
use App\Modules\Finances\Application\Wallet\GetAll\GetAllWalletsQuery;
use App\Modules\Finances\Application\Wallet\GetAll\WalletsCollection;
use App\Modules\Finances\Application\Wallet\GetOneById\GetOneWalletByIdQuery;
use App\Modules\Finances\Application\Wallet\GetOneById\WalletDTO;
use App\Modules\Finances\Application\Wallet\Update\UpdateWalletCommand;
use App\Web\API\Request\Finances\Wallet\CreateWalletRequest;
use App\Web\API\Request\Finances\Wallet\DeleteWalletRequest;
use App\Web\API\Request\Finances\Wallet\GetAllWalletsRequest;
use App\Web\API\Request\Finances\Wallet\GetOneWalletByIdRequest;
use App\Web\API\Request\Finances\Wallet\UpdateWalletRequest;
use App\Web\API\Response\Finances\Wallet\WalletResponse;
use App\Web\API\Response\Finances\Wallet\WalletsResponse;
use App\Web\API\Service\Finances\User\UserService;
use App\Web\API\ViewModel\Finances\Wallet\Wallet;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class DirectCallWalletService implements WalletService
{
    private MessageBusInterface $bus;
    private UserService $userService;

    public function __construct(MessageBusInterface $bus, UserService $userService)
    {
        $this->bus = $bus;
        $this->userService = $userService;
    }

    public function createWallet(CreateWalletRequest $request): void
    {
        $userId = $this->userService->getUserIdByToken($request->getUserToken());

        $this->bus->dispatch(
            new CreateWalletCommand(
                $request->getWalletName(),
                $request->getWalletStartBalance(),
                $userId
            )
        );
    }

    public function deleteWallet(DeleteWalletRequest $request): void
    {
        $userId = $this->userService->getUserIdByToken($request->getUserToken());

        $this->bus->dispatch(
            new DeleteWalletCommand(
                $request->getWalletId(),
                $userId
            )
        );
    }

    public function getAllWallets(GetAllWalletsRequest $request): WalletsResponse
    {
        $query = new GetAllWalletsQuery(
            $this->userService->getUserIdByToken($request->getUserToken())
        );

        /** @var WalletsCollection $result */
        $result = $this->bus->dispatch($query)
            ->last(HandledStamp::class)
            ->getResult();

        return WalletsResponse::createFromCollection($result);
    }

    public function getOneWalletById(GetOneWalletByIdRequest $request): WalletResponse
    {
        $query = new GetOneWalletByIdQuery(
            $request->getWalletId(),
            $this->userService->getUserIdByToken($request->getUserToken())
        );

        /** @var WalletDTO $wallet */
        $wallet = $this->bus->dispatch($query)
            ->last(HandledStamp::class)
            ->getResult();

        return new WalletResponse(
            $wallet->getId(),
            $wallet->getName(),
            $wallet->getStartBalance(),
            $wallet->getUserId(),
            $wallet->getCreatedAt()
        );
    }

    public function updateWallet(UpdateWalletRequest $request): void
    {
        $userId = $this->userService->getUserIdByToken($request->getUserToken());

        $this->bus->dispatch(
            new UpdateWalletCommand(
                $request->getWalletId(),
                $userId,
                $request->getWalletName(),
                $request->getWalletStartBalance()
            )
        );
    }
}
