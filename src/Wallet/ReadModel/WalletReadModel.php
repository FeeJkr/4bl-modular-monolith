<?php
declare(strict_types=1);

namespace App\Wallet\ReadModel;

use App\Wallet\ReadModel\Query\FetchAllWalletsQuery;
use App\Wallet\ReadModel\Query\FetchOneWalletByIdQuery;
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
