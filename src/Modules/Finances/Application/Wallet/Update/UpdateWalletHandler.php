<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet\Update;

use App\Modules\Finances\Domain\Money;
use App\Modules\Finances\Domain\User\UserContext;
use App\Modules\Finances\Domain\Wallet\WalletId;
use App\Modules\Finances\Domain\Wallet\WalletRepository;

final class UpdateWalletHandler
{
    private WalletRepository $repository;
    private UserContext $userContext;

    public function __construct(WalletRepository $repository, UserContext $userContext)
    {
        $this->repository = $repository;
        $this->userContext = $userContext;
    }

    public function __invoke(UpdateWalletCommand $command): void
    {
        $walletId = WalletId::fromInt($command->getWalletId());
        $userId = $this->userContext->getUserId();
        $startBalance = new Money($command->getStartBalance());

        $wallet = $this->repository->fetchById($walletId, $userId);

        $wallet->update($command->getName(), $startBalance, $userId);

        $this->repository->save($wallet);
    }
}
