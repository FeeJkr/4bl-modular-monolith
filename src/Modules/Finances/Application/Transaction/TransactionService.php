<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Transaction;

use App\Modules\Finances\Application\Transaction\Command\CreateTransactionCommand;
use App\Modules\Finances\Application\Transaction\Command\DeleteTransactionCommand;
use App\Modules\Finances\Application\Transaction\Command\UpdateTransactionCommand;
use App\Modules\Finances\Domain\Transaction\Transaction;
use App\Modules\Finances\Domain\Transaction\TransactionRepository;

final class TransactionService
{
    private TransactionRepository $repository;

    public function __construct(TransactionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createNew(CreateTransactionCommand $command): void
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

    public function deleteTransaction(DeleteTransactionCommand $command): void
    {
        $this->repository->delete($command->getTransactionId(), $command->getUserId());
    }

    public function updateTransaction(UpdateTransactionCommand $command): void
    {
        $transaction = $this->repository->fetchById($command->getTransactionId(), $command->getUserId());

        $transaction->update(
            $command->getUserId(),
            $command->getWalletId(),
            $command->getLinkedWalletId(),
            $command->getCategoryId(),
            $command->getTransactionType(),
            $command->getAmount(),
            $command->getDescription(),
            $command->getOperationAt()
        );

        $this->repository->save($transaction);
    }
}
