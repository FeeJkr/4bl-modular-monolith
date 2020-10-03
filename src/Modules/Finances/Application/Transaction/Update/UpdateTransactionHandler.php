<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Transaction\Update;

use App\Modules\Finances\Domain\Transaction\TransactionRepository;

final class UpdateTransactionHandler
{
    private TransactionRepository $repository;

    public function __construct(TransactionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(UpdateTransactionCommand $command): void
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
