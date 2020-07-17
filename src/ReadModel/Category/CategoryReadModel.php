<?php
declare(strict_types=1);

namespace App\ReadModel\Category;

use Doctrine\Common\Collections\Collection;

final class CategoryReadModel
{
    private $repository;

    public function __construct(CategoryReadModelRepository $repository)
    {
        $this->repository = $repository;
    }

    public function fetchAll(FetchAllQuery $query): Collection
    {
        return $this->repository->fetchAll($query->getUserId());
    }
}
