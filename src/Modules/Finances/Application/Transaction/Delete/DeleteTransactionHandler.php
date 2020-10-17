<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Transaction\Delete;

use App\Modules\Finances\Domain\Transaction\TransactionId;
use App\Modules\Finances\Domain\Transaction\TransactionRepository;
use App\Modules\Finances\Domain\User\UserId;

final class DeleteTransactionHandler
{
    private TransactionRepository $repository;

    public function __construct(TransactionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(DeleteTransactionCommand $command): void
    {
        $this->repository->delete(
            TransactionId::fromInt($command->getTransactionId()),
            UserId::fromInt($command->getUserId())
        );
    }
}
