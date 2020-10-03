<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Transaction;

use App\Modules\Finances\Application\Transaction\Command\CreateTransactionCommand;
use App\Modules\Finances\Application\Transaction\Command\DeleteTransactionCommand;
use App\Modules\Finances\Application\Transaction\Command\UpdateTransactionCommand;
use App\Modules\Finances\Application\Transaction\Query\FetchAllTransactionsByWalletQuery;
use App\Modules\Finances\Application\Transaction\Query\FetchAllTransactionsQuery;
use App\Modules\Finances\Application\Transaction\Query\FetchOneTransactionByIdQuery;
use App\Modules\Finances\Domain\Transaction\Transaction;
use App\Modules\Finances\Domain\Transaction\TransactionRepository;
use Doctrine\Common\Collections\Collection;

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

    public function fetchAllByWallet(FetchAllTransactionsByWalletQuery $query): Collection
    {
        return $this->repository->fetchAllByWallet($query->getWalletId(), $query->getUserId());
    }

    public function fetchOneById(FetchOneTransactionByIdQuery $query): TransactionDTO
    {
        return $this->repository->fetchOneById($query->getTransactionId(), $query->getUserId());
    }

    public function fetchAll(FetchAllTransactionsQuery $query): Collection
    {
        return $this->repository->fetchAll($query->getUserId());
    }
}
