<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet\FetchAll;

use App\Modules\Finances\Domain\User\UserId;
use App\Modules\Finances\Domain\Wallet\Wallet;
use App\Modules\Finances\Domain\Wallet\WalletRepository;

final class FetchAllWalletsHandler
{
    private WalletRepository $repository;

    public function __construct(WalletRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(FetchAllWalletsQuery $query): WalletsCollection
    {
        $data = [];
        $wallets = $this->repository->fetchAll(UserId::fromInt($query->getUserId()));

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
