<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet\GetAll;

use App\Modules\Finances\Domain\User\UserContext;
use App\Modules\Finances\Domain\Wallet\Wallet;
use App\Modules\Finances\Domain\Wallet\WalletRepository;

final class GetAllWalletsHandler
{
    private WalletRepository $repository;
    private UserContext $userContext;

    public function __construct(WalletRepository $repository, UserContext $userContext)
    {
        $this->repository = $repository;
        $this->userContext = $userContext;
    }

    public function __invoke(GetAllWalletsQuery $query): WalletsCollection
    {
        $data = [];
        $wallets = $this->repository->fetchAll(
            $this->userContext->getUserId()
        );

        /** @var Wallet $wallet */
        foreach ($wallets as $wallet) {
            $data[] = new WalletDTO(
                $wallet->getId()->toInt(),
                $wallet->getName(),
                $wallet->getStartBalance()->getAmount(),
                $wallet->getUserId()->toInt(),
                $wallet->getCreatedAt()
            );
        }

        return new WalletsCollection($data);
    }
}
