<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet\GetOneById;

use App\Modules\Finances\Domain\User\UserContext;
use App\Modules\Finances\Domain\User\UserId;
use App\Modules\Finances\Domain\Wallet\WalletException;
use App\Modules\Finances\Domain\Wallet\WalletId;
use App\Modules\Finances\Domain\Wallet\WalletRepository;

final class GetOneWalletByIdHandler
{
    private WalletRepository $repository;
    private UserContext $userContext;

    public function __construct(WalletRepository $repository, UserContext $userContext)
    {
        $this->repository = $repository;
        $this->userContext = $userContext;
    }

    public function __invoke(GetOneWalletByIdQuery $query): WalletDTO
    {
        $walletId = WalletId::fromInt($query->getWalletId());
        $userId = $this->userContext->getUserId();

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
