<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Transaction\FetchOneById;

use App\Modules\Finances\Domain\Transaction\TransactionRepository;

final class FetchOneTransactionByIdHandler
{
    private TransactionRepository $repository;

    public function __construct(TransactionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(FetchOneTransactionByIdQuery $query): TransactionDTO
    {
        return $this->repository->fetchOneById($query->getTransactionId(), $query->getUserId());
    }
}
