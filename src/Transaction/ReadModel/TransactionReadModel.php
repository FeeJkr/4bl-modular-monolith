<?php
declare(strict_types=1);

namespace App\Transaction\ReadModel;

use App\Transaction\ReadModel\Query\FetchAllTransactionsByWalletQuery;
use App\Transaction\ReadModel\Query\FetchAllTransactionsQuery;
use App\Transaction\ReadModel\Query\FetchOneTransactionByIdQuery;
use Doctrine\Common\Collections\Collection;

final class TransactionReadModel
{
    private TransactionReadModelRepository $repository;

    public function __construct(TransactionReadModelRepository $repository)
    {
        $this->repository = $repository;
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
