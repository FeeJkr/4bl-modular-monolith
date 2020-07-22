<?php
declare(strict_types=1);

namespace App\ReadModel\Transaction;

use App\ReadModel\Transaction\Query\FetchAllByWalletQuery;
use App\ReadModel\Transaction\Query\FetchAllQuery;
use App\ReadModel\Transaction\Query\FetchOneByIdQuery;
use Doctrine\Common\Collections\Collection;

final class TransactionReadModel
{
    private $repository;

    public function __construct(TransactionReadModelRepository $repository)
    {
        $this->repository = $repository;
    }

    public function fetchAllByWallet(FetchAllByWalletQuery $query): Collection
    {
        return $this->repository->fetchAllByWallet($query->getWalletId(), $query->getUserId());
    }

    public function fetchOneById(FetchOneByIdQuery $query): TransactionDTO
    {
        return $this->repository->fetchOneById($query->getTransactionId(), $query->getUserId());
    }

    public function fetchAll(FetchAllQuery $query): Collection
    {
        return $this->repository->fetchAll($query->getUserId());
    }
}
