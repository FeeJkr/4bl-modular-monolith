<?php
declare(strict_types=1);

namespace App\Category\ReadModel;

use App\Category\ReadModel\Query\FetchAllCategoriesQuery;
use App\Category\ReadModel\Query\FetchOneCategoryByIdQuery;
use Doctrine\Common\Collections\Collection;

final class CategoryReadModel
{
    private $repository;

    public function __construct(CategoryReadModelRepository $repository)
    {
        $this->repository = $repository;
    }

    public function fetchAll(FetchAllCategoriesQuery $query): Collection
    {
        return $this->repository->fetchAll($query->getUserId());
    }

    public function fetchOneById(FetchOneCategoryByIdQuery $query): ?CategoryDTO
    {
        $categoryDTO = $this->repository->fetchOneById($query->getUserId(), $query->getCategoryId());

        if ($categoryDTO === null) {
            throw CategoryReadModelException::notFoundById($query->getCategoryId());
        }

        return $categoryDTO;
    }
}
