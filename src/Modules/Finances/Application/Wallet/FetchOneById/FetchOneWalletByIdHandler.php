<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet\FetchOneById;

use App\Modules\Finances\Domain\User\UserId;
use App\Modules\Finances\Domain\Wallet\WalletException;
use App\Modules\Finances\Domain\Wallet\WalletId;
use App\Modules\Finances\Domain\Wallet\WalletRepository;

final class FetchOneWalletByIdHandler
{
    private WalletRepository $repository;

    public function __construct(WalletRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(FetchOneWalletByIdQuery $query): WalletDTO
    {
        $walletId = WalletId::fromInt($query->getWalletId());
        $userId = UserId::fromInt($query->getUserId());

        $wallet = $this->repository->fetchById($walletId, $userId);

        if ($wallet === null) {
            throw WalletException::notFound($walletId, $userId);
        }

        return new WalletDTO(
            $wallet->getId()->toInt(),
            $wallet->getName(),
            $wallet->getStartBalance()->getAmount(),
            $wallet->getUserId()->toInt(),
            $wallet->getCreatedAt()
        );
    }
}
