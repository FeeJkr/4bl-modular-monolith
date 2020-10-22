<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Transaction\GetAllByWallet;

use App\Modules\Finances\Domain\Transaction\Transaction;
use App\Modules\Finances\Domain\Transaction\TransactionRepository;
use App\Modules\Finances\Domain\User\UserId;
use App\Modules\Finances\Domain\Wallet\WalletId;

final class GetAllTransactionsByWalletHandler
{
    private TransactionRepository $repository;

    public function __construct(TransactionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(GetAllTransactionsByWalletQuery $query): TransactionsCollection
    {
        $data = [];
        $transactions = $this->repository->fetchAllByWallet(
            WalletId::fromInt($query->getWalletId()),
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
