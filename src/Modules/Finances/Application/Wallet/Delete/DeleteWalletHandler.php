<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet\Delete;

use App\Modules\Finances\Domain\User\UserContext;
use App\Modules\Finances\Domain\Wallet\WalletId;
use App\Modules\Finances\Domain\Wallet\WalletRepository;

final class DeleteWalletHandler
{
    private WalletRepository $repository;
    private UserContext $userContext;

    public function __construct(WalletRepository $repository, UserContext $userContext)
    {
        $this->repository = $repository;
        $this->userContext = $userContext;
    }

    public function __invoke(DeleteWalletCommand $command): void
    {
        $this->repository->delete(
            WalletId::fromInt($command->getWalletId()),
            $this->userContext->getUserId()
        );
    }
}
