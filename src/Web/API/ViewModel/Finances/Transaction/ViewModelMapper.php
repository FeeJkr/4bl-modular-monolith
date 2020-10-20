<?php
declare(strict_types=1);

namespace App\Web\API\ViewModel\Finances\Transaction;

use App\Modules\Finances\Application\Transaction\FetchAll\TransactionsCollection;
use App\Modules\Finances\Application\Transaction\FetchAllByWallet\TransactionsCollection as TransactionsCollectionByWalletId;
use App\Modules\Finances\Application\Transaction\FetchOneById\TransactionDTO;

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

        /** @var \App\Modules\Finances\Application\Transaction\FetchAll\TransactionDTO $dto */
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

        /** @var \App\Modules\Finances\Application\Transaction\FetchAllByWallet\TransactionDTO $dto */
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
