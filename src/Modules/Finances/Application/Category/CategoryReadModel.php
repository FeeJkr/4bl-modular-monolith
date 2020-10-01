<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category;

use App\Modules\Finances\Application\Category\Query\FetchAllCategoriesQuery;
use App\Modules\Finances\Application\Category\Query\FetchOneCategoryByIdQuery;
use Doctrine\Common\Collections\Collection;

final class CategoryReadModel
{
    private CategoryReadModelRepository $repository;

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
