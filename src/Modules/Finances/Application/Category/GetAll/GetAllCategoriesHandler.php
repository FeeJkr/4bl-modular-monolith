<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\GetAll;

use App\Modules\Finances\Domain\Category\Category;
use App\Modules\Finances\Domain\Category\CategoryRepository;
use App\Modules\Finances\Domain\User\UserContext;

final class GetAllCategoriesHandler
{
    public function __construct(private CategoryRepository $repository, private UserContext $userContext) {}

    public function __invoke(GetAllCategoriesQuery $query): CategoriesCollection
    {
        $data = [];
        $categories = $this->repository->fetchAll($this->userContext->getUserId());

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
