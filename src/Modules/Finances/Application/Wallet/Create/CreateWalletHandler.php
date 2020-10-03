<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet\Create;

use App\Modules\Finances\Domain\Wallet\Wallet;
use App\Modules\Finances\Domain\Wallet\WalletRepository;

final class CreateWalletHandler
{
    private WalletRepository $repository;

    public function __construct(WalletRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(CreateWalletCommand $command): void
    {
        $wallet = Wallet::createNew(
            $command->getName(),
            $command->getStartBalance(),
            $command->getUserId()
        );

        $this->repository->store($wallet);
    }
}
