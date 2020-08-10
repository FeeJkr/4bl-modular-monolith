<?php
declare(strict_types=1);

namespace App\Transaction\Application;

use App\Transaction\Application\Command\CreateTransactionCommand;
use App\Transaction\Application\Command\DeleteTransactionCommand;
use App\Transaction\Application\Command\UpdateTransactionCommand;
use App\Transaction\Domain\Transaction;
use App\Transaction\Domain\TransactionRepository;

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
