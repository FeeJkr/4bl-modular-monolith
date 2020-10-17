<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\FetchAll;

use App\Modules\Finances\Domain\Category\Category;
use App\Modules\Finances\Domain\Category\CategoryRepository;
use App\Modules\Finances\Domain\User\UserId;

final class FetchAllCategoriesHandler
{
    private CategoryRepository $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(FetchAllCategoriesQuery $query): CategoriesCollection
    {
        $data = [];
        $categories = $this->repository->fetchAll(UserId::fromInt($query->getUserId()));

        /** @var Category $category */
        foreach ($categories as $category) {
            $data[] = new CategoryDTO(
                $category->getId()->toInt(),
                $category->getUserId()->toInt(),
                $category->getName(),
                $category->getType()->getValue(),
                $category->getIcon(),
                $category->getCreatedAt()
            );
        }

        return new CategoriesCollection($data);
    }
}
