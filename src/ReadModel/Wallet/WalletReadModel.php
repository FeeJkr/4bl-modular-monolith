<?php
declare(strict_types=1);

namespace App\ReadModel\Wallet;

use App\ReadModel\Wallet\Query\FetchAllQuery;
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
}
