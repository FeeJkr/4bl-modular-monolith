<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Transaction\Delete;

use App\Modules\Finances\Domain\Transaction\TransactionId;
use App\Modules\Finances\Domain\Transaction\TransactionRepository;
use App\Modules\Finances\Domain\User\UserContext;
use App\Modules\Finances\Domain\User\UserId;

final class DeleteTransactionHandler
{
    private TransactionRepository $repository;
    private UserContext $userContext;

    public function __construct(TransactionRepository $repository, UserContext $userContext)
    {
        $this->repository = $repository;
        $this->userContext = $userContext;
    }

    public function __invoke(DeleteTransactionCommand $command): void
    {
        $this->repository->delete(
            TransactionId::fromInt($command->getTransactionId()),
            $this->userContext->getUserId()
        );
    }
}
