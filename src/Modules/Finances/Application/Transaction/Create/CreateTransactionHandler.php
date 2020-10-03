<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Transaction\Create;

use App\Modules\Finances\Domain\Transaction\Transaction;
use App\Modules\Finances\Domain\Transaction\TransactionRepository;

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
            $command->getUserId(),
            $command->getWalletId(),
            $command->getLinkedWalletId(),
            $command->getCategoryId(),
            $command->getTransactionType(),
            $command->getAmount(),
            $command->getDescription(),
            $command->getOperationAt()
        );

        $this->repository->store($transaction);
    }
}
