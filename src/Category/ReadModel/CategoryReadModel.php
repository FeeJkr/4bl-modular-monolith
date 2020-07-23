<?php
declare(strict_types=1);

namespace App\Category\ReadModel;

use App\Category\ReadModel\Query\FetchAllQuery;
use App\Category\ReadModel\Query\FetchOneByIdQuery;
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

    public function fetchOneById(FetchOneByIdQuery $query): ?CategoryDTO
    {
        $categoryDTO = $this->repository->fetchOneById($query->getUserId(), $query->getCategoryId());

        if ($categoryDTO === null) {
            throw CategoryReadModelException::notFoundById($query->getCategoryId());
        }

        return $categoryDTO;
    }
}
