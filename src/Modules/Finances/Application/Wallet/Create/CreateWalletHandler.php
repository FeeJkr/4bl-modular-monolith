<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet\Create;

use App\Modules\Finances\Domain\Money;
use App\Modules\Finances\Domain\User\UserContext;
use App\Modules\Finances\Domain\User\UserId;
use App\Modules\Finances\Domain\Wallet\Wallet;
use App\Modules\Finances\Domain\Wallet\WalletRepository;

final class CreateWalletHandler
{
    private WalletRepository $repository;
    private UserContext $userContext;

    public function __construct(WalletRepository $repository, UserContext $userContext)
    {
        $this->repository = $repository;
        $this->userContext = $userContext;
    }

    public function __invoke(CreateWalletCommand $command): void
    {
        $wallet = Wallet::createNew(
            $command->getName(),
            new Money($command->getStartBalance()),
            $this->userContext->getUserId()
        );

        $this->repository->store($wallet);
    }
}
