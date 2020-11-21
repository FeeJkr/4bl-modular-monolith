<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Transaction\GetAll;

use App\Modules\Finances\Domain\Transaction\Transaction;
use App\Modules\Finances\Domain\Transaction\TransactionRepository;
use App\Modules\Finances\Domain\User\UserContext;

final class GetAllTransactionsHandler
{
    private TransactionRepository $repository;
    private UserContext $userContext;

    public function __construct(TransactionRepository $repository, UserContext $userContext)
    {
        $this->repository = $repository;
        $this->userContext = $userContext;
    }

    public function __invoke(GetAllTransactionsQuery $query): TransactionsCollection
    {
        $data = [];
        $transactions = $this->repository->fetchAll(
            $this->userContext->getUserId()
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
