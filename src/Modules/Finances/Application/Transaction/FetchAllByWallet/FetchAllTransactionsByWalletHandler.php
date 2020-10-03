<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Transaction\FetchAllByWallet;

use App\Modules\Finances\Domain\Transaction\TransactionRepository;
use Doctrine\Common\Collections\Collection;

final class FetchAllTransactionsByWalletHandler
{
    private TransactionRepository $repository;

    public function __construct(TransactionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(FetchAllTransactionsByWalletQuery $query): Collection
    {
        return $this->repository->fetchAllByWallet($query->getWalletId(), $query->getUserId());
    }
}
