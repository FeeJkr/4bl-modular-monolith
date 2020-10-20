<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Transaction\FetchAll;

use App\Modules\Finances\Domain\Transaction\Transaction;
use App\Modules\Finances\Domain\Transaction\TransactionRepository;
use App\Modules\Finances\Domain\User\UserId;

final class FetchAllTransactionsHandler
{
    private TransactionRepository $repository;

    public function __construct(TransactionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(FetchAllTransactionsQuery $query): TransactionsCollection
    {
        $data = [];
        $transactions = $this->repository->fetchAll(
            UserId::fromInt($query->getUserId())
        );

        /** @var Transaction $transaction */
        foreach ($transactions as $transaction) {
            $data[] = new TransactionDTO(
                $transaction->getId()->toInt(),
                $transaction->getLinkedTransaction() !== null
                    ? $transaction->getLinkedTransaction()->getId()->toInt()
                    : null,
                $transaction->getUserId()->toInt(),
                $transaction->getWalletId()->toInt(),
                $transaction->getCategoryId()->toInt(),
                $transaction->getType()->getValue(),
                $transaction->getAmount()->getAmount(),
                $transaction->getDescription(),
                $transaction->getOperationAt(),
                $transaction->getCreatedAt()
            );
        }

        return new TransactionsCollection($data);
    }
}
