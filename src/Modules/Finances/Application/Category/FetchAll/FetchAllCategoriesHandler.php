<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\FetchAll;

use App\Modules\Finances\Domain\Category\CategoryRepository;
use Doctrine\Common\Collections\Collection;

final class FetchAllCategoriesHandler
{
    private CategoryRepository $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(FetchAllCategoriesQuery $query): Collection
    {
        return $this->repository->fetchAll($query->getUserId());
    }
}
