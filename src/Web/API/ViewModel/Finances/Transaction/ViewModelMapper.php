<?php
declare(strict_types=1);

namespace App\Web\API\ViewModel\Finances\Transaction;

use App\Modules\Finances\Application\Transaction\GetAll\TransactionsCollection;
use App\Modules\Finances\Application\Transaction\GetAllByWallet\TransactionsCollection as TransactionsCollectionByWalletId;
use App\Modules\Finances\Application\Transaction\GetOneById\TransactionDTO;

final class ViewModelMapper
{
    public function map(TransactionDTO $dto): Transaction
    {
        return new Transaction(
            $dto->getId(),
            $dto->getLinkedTransactionId(),
            $dto->getUserId(),
            $dto->getWalletId(),
            $dto->getCategoryId(),
            $dto->getTransactionType(),
            $dto->getAmount(),
            $dto->getDescription(),
            $dto->getOperationAt(),
            $dto->getCreatedAt()
        );
    }

    public function mapTransactionsCollection(TransactionsCollection $transactionsCollection): array
    {
        $transactions = [];

        /** @var \App\Modules\Finances\Application\Transaction\GetAll\TransactionDTO $dto */
        foreach ($transactionsCollection->getTransactions() as $dto) {
            $transactions[] = new Transaction(
                $dto->getId(),
                $dto->getLinkedTransactionId(),
                $dto->getUserId(),
                $dto->getWalletId(),
                $dto->getCategoryId(),
                $dto->getTransactionType(),
                $dto->getAmount(),
                $dto->getDescription(),
                $dto->getOperationAt(),
                $dto->getCreatedAt()
            );
        }

        return $transactions;
    }

    public function mapTransactionCollectionByWalletId(TransactionsCollectionByWalletId $transactionsCollection): array
    {
        $transactions = [];

        /** @var \App\Modules\Finances\Application\Transaction\GetAllByWallet\TransactionDTO $dto */
        foreach ($transactionsCollection->getTransactions() as $dto) {
            $transactions[] = new Transaction(
                $dto->getId(),
                $dto->getLinkedTransactionId(),
                $dto->getUserId(),
                $dto->getWalletId(),
                $dto->getCategoryId(),
                $dto->getTransactionType(),
                $dto->getAmount(),
                $dto->getDescription(),
                $dto->getOperationAt(),
                $dto->getCreatedAt()
            );
        }

        return $transactions;
    }
}
