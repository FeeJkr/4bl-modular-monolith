<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\GetAllGroupedByType;

use App\Modules\Finances\Domain\Category\Category;
use App\Modules\Finances\Domain\Category\CategoryRepository;
use App\Modules\Finances\Domain\User\UserContext;

final class GetAllGroupedByTypeHandler
{
    public function __construct(private CategoryRepository $repository, private UserContext $userContext) {}

    public function __invoke(GetAllGroupedByTypeQuery $query): GroupedByTypeCategoriesCollection
    {
        $data = [];
        $groupedCategories = $this->repository->fetchAllGroupedByType($this->userContext->getUserId());

        /** @var Category $category */
        foreach ($groupedCategories as $categories) {
            foreach ($categories as $category) {
                $type = $category->getType()->getValue();

                $data[$type][] = new CategoryDTO(
                    $category->getId()->toInt(),
                    $category->getName(),
                    $type,
                    $category->getIcon(),
                    $category->getCreatedAt()
                );
            }
        }

        return new GroupedByTypeCategoriesCollection($data);
    }
}
