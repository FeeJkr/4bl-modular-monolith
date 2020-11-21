<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Transaction\GetOneById;

use App\Modules\Finances\Domain\Transaction\TransactionId;
use App\Modules\Finances\Domain\Transaction\TransactionRepository;
use App\Modules\Finances\Domain\User\UserContext;

final class GetOneTransactionByIdHandler
{
    private TransactionRepository $repository;
    private UserContext $userContext;

    public function __construct(TransactionRepository $repository, UserContext $userContext)
    {
        $this->repository = $repository;
        $this->userContext = $userContext;
    }

    public function __invoke(GetOneTransactionByIdQuery $query): TransactionDTO
    {
        $transaction = $this->repository->fetchById(
            TransactionId::fromInt($query->getTransactionId()),
            $this->userContext->getUserId()
        );

        return new TransactionDTO(
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
}
