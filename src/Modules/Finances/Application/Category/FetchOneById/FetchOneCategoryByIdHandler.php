<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\FetchOneById;

use App\Modules\Finances\Domain\Category\CategoryException;
use App\Modules\Finances\Domain\Category\CategoryId;
use App\Modules\Finances\Domain\Category\CategoryRepository;
use App\Modules\Finances\Domain\User\UserId;

final class FetchOneCategoryByIdHandler
{
    private CategoryRepository $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(FetchOneCategoryByIdQuery $query): CategoryDTO
    {
        $userId = UserId::fromInt($query->getUserId());
        $categoryId = CategoryId::fromInt($query->getCategoryId());

        $category = $this->repository->fetchById($categoryId, $userId);

        if ($category === null) {
            throw CategoryException::notFoundById($categoryId);
        }

        return new CategoryDTO(
            $category->getId()->toInt(),
            $category->getUserId()->toInt(),
            $category->getName(),
            $category->getType()->getValue(),
            $category->getIcon(),
            $category->getCreatedAt()
        );
    }
}
