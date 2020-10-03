<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Transaction\Delete;

use App\Modules\Finances\Domain\Transaction\TransactionRepository;

final class DeleteTransactionHandler
{
    private TransactionRepository $repository;

    public function __construct(TransactionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(DeleteTransactionCommand $command): void
    {
        $this->repository->delete($command->getTransactionId(), $command->getUserId());
    }
}
