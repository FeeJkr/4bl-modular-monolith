<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Transaction\Create;

use App\Modules\Finances\Domain\Category\CategoryId;
use App\Modules\Finances\Domain\Money;
use App\Modules\Finances\Domain\Transaction\Transaction;
use App\Modules\Finances\Domain\Transaction\TransactionRepository;
use App\Modules\Finances\Domain\Transaction\TransactionType;
use App\Modules\Finances\Domain\User\UserId;
use App\Modules\Finances\Domain\Wallet\WalletId;

final class CreateTransactionHandler
{
    private TransactionRepository $repository;

    public function __construct(TransactionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(CreateTransactionCommand $command): void
    {
        $transaction = Transaction::createNew(
            UserId::fromInt($command->getUserId()),
            WalletId::fromInt($command->getWalletId()),
            WalletId::fromInt($command->getLinkedWalletId()),
            CategoryId::fromInt($command->getCategoryId()),
            new TransactionType($command->getTransactionType()),
            new Money($command->getAmount()),
            $command->getDescription(),
            $command->getOperationAt()
        );

        $this->repository->store($transaction);
    }
}
