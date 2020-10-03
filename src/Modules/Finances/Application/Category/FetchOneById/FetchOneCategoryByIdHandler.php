<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\FetchOneById;

use App\Modules\Finances\Domain\Category\CategoryException;
use App\Modules\Finances\Domain\Category\CategoryRepository;

final class FetchOneCategoryByIdHandler
{
    private CategoryRepository $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(FetchOneCategoryByIdQuery $query): ?CategoryDTO
    {
        $categoryDTO = $this->repository->fetchOneById($query->getUserId(), $query->getCategoryId());

        if ($categoryDTO === null) {
            throw CategoryException::notFoundById($query->getCategoryId());
        }

        return $categoryDTO;
    }
}
