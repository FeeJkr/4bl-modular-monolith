<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Transaction\FetchAll;

use App\Modules\Finances\Domain\Transaction\TransactionRepository;
use Doctrine\Common\Collections\Collection;

final class FetchAllTransactionsHandler
{
    private TransactionRepository $repository;

    public function __construct(TransactionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(FetchAllTransactionsQuery $query): Collection
    {
        return $this->repository->fetchAll($query->getUserId());
    }
}
