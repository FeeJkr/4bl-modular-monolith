<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Wallet;

use App\Modules\Finances\Application\Wallet\Query\FetchAllWalletsQuery;
use App\Modules\Finances\Application\Wallet\Query\FetchOneWalletByIdQuery;
use Doctrine\Common\Collections\ArrayCollection;

final class WalletReadModel
{
    private WalletReadModelRepository $repository;

    public function __construct(WalletReadModelRepository $repository)
    {
        $this->repository = $repository;
    }

    public function fetchAll(FetchAllWalletsQuery $query): ArrayCollection
    {
        return $this->repository->fetchAll($query->getUserId());
    }

    public function fetchOneById(FetchOneWalletByIdQuery $query): WalletDTO
    {
        $walletDTO = $this->repository->fetchOneById($query->getWalletId(), $query->getUserId());

        if ($walletDTO === null) {
            throw WalletReadModelException::notFound($query->getWalletId(), $query->getUserId());
        }

        return $walletDTO;
    }
}
