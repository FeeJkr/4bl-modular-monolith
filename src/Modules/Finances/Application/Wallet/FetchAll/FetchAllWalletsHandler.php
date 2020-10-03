<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet\FetchAll;

use App\Modules\Finances\Domain\Wallet\WalletRepository;
use Doctrine\Common\Collections\ArrayCollection;

final class FetchAllWalletsHandler
{
    private WalletRepository $repository;

    public function __construct(WalletRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(FetchAllWalletsQuery $query): ArrayCollection
    {
        return $this->repository->fetchAll($query->getUserId());
    }
}
