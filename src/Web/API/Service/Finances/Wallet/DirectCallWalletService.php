<?php
declare(strict_types=1);

namespace App\Web\API\Service\Finances\Wallet;

use App\Modules\Finances\Application\Wallet\Create\CreateWalletCommand;
use App\Modules\Finances\Application\Wallet\Delete\DeleteWalletCommand;
use App\Modules\Finances\Application\Wallet\FetchAll\FetchAllWalletsQuery;
use App\Modules\Finances\Application\Wallet\FetchAll\WalletsCollection;
use App\Modules\Finances\Application\Wallet\FetchOneById\FetchOneWalletByIdQuery;
use App\Modules\Finances\Application\Wallet\FetchOneById\WalletDTO;
use App\Modules\Finances\Application\Wallet\Update\UpdateWalletCommand;
use App\Web\API\Request\Finances\Wallet\CreateWalletRequest;
use App\Web\API\Request\Finances\Wallet\DeleteWalletRequest;
use App\Web\API\Request\Finances\Wallet\GetAllWalletsRequest;
use App\Web\API\Request\Finances\Wallet\GetOneWalletByIdRequest;
use App\Web\API\Request\Finances\Wallet\UpdateWalletRequest;
use App\Web\API\Service\Finances\User\UserService;
use App\Web\API\ViewModel\Finances\Wallet\ViewModelMapper;
use App\Web\API\ViewModel\Finances\Wallet\Wallet;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class DirectCallWalletService implements WalletService
{
    private MessageBusInterface $bus;
    private UserService $userService;
    private ViewModelMapper $viewModelMapper;

    public function __construct(MessageBusInterface $bus, UserService $userService, ViewModelMapper $viewModelMapper)
    {
        $this->bus = $bus;
        $this->userService = $userService;
        $this->viewModelMapper = $viewModelMapper;
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

    public function getAllWallets(GetAllWalletsRequest $request): array
    {
        $query = new FetchAllWalletsQuery(
            $this->userService->getUserIdByToken($request->getUserToken())
        );

        /** @var WalletsCollection $result */
        $result = $this->bus->dispatch($query)
            ->last(HandledStamp::class)
            ->getResult()
            ->toArray();

        return $this->viewModelMapper->mapCollection($result);
    }

    public function getOneWalletById(GetOneWalletByIdRequest $request): Wallet
    {
        $query = new FetchOneWalletByIdQuery(
            $request->getWalletId(),
            $this->userService->getUserIdByToken($request->getUserToken())
        );

        /** @var WalletDTO $result */
        $walletDto = $this->bus->dispatch($query)
            ->last(HandledStamp::class)
            ->getResult();

        return $this->viewModelMapper->map($walletDto);
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
