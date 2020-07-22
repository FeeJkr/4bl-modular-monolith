<?php
declare(strict_types=1);

namespace App\Application\Transaction;

use App\Application\Transaction\Command\CreateNewTransactionCommand;
use App\Application\Transaction\Command\DeleteTransactionCommand;
use App\Application\Transaction\Command\UpdateTransactionCommand;
use App\DomainModel\Transaction\Transaction;
use App\DomainModel\Transaction\TransactionRepository;

final class TransactionService
{
    private $repository;

    public function __construct(TransactionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createNew(CreateNewTransactionCommand $command): void
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
