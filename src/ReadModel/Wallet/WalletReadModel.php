<?php
declare(strict_types=1);

namespace App\ReadModel\Wallet;

use App\ReadModel\Wallet\Query\FetchAllQuery;
use App\ReadModel\Wallet\Query\FetchOneByIdQuery;
use Doctrine\Common\Collections\ArrayCollection;

final class WalletReadModel
{
    private $repository;

    public function __construct(WalletReadModelRepository $repository)
    {
        $this->repository = $repository;
    }

    public function fetchAll(FetchAllQuery $query): ArrayCollection
    {
        return $this->repository->fetchAll($query->getUserId());
    }

    public function fetchOneById(FetchOneByIdQuery $query): WalletDTO
    {
        $walletDTO = $this->repository->fetchOneById($query->getWalletId(), $query->getUserId());

        if ($walletDTO === null) {
            throw WalletReadModelException::notFound($query->getWalletId(), $query->getUserId());
        }

        return $walletDTO;
    }
}
