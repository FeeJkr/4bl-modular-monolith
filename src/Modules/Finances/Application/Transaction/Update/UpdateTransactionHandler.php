<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Transaction\Update;

use App\Modules\Finances\Domain\Category\CategoryId;
use App\Modules\Finances\Domain\Money;
use App\Modules\Finances\Domain\Transaction\TransactionId;
use App\Modules\Finances\Domain\Transaction\TransactionRepository;
use App\Modules\Finances\Domain\Transaction\TransactionType;
use App\Modules\Finances\Domain\User\UserContext;
use App\Modules\Finances\Domain\User\UserId;
use App\Modules\Finances\Domain\Wallet\WalletId;

final class UpdateTransactionHandler
{
    private TransactionRepository $repository;
    private UserContext $userContext;

    public function __construct(TransactionRepository $repository, UserContext $userContext)
    {
        $this->repository = $repository;
        $this->userContext = $userContext;
    }

    public function __invoke(UpdateTransactionCommand $command): void
    {
        $userId = $this->userContext->getUserId();

        $transaction = $this->repository->fetchById(
            TransactionId::fromInt($command->getTransactionId()),
            $userId
        );

        $transaction->update(
            $userId,
            WalletId::fromInt($command->getWalletId()),
            WalletId::fromInt($command->getLinkedWalletId()),
            CategoryId::fromInt($command->getCategoryId()),
            new TransactionType($command->getTransactionType()),
            new Money($command->getAmount()),
            $command->getDescription(),
            $command->getOperationAt()
        );

        $this->repository->save($transaction);
    }
}
