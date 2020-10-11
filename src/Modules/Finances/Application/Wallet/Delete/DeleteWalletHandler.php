<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet\Delete;

use App\Modules\Finances\Domain\Wallet\WalletRepository;

final class DeleteWalletHandler
{
    private WalletRepository $repository;

    public function __construct(WalletRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(DeleteWalletCommand $command): void
    {
        $this->repository->delete($command->getWalletId(), $command->getUserId());
    }
}