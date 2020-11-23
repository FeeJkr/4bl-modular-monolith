<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\GetOneById;

use App\Modules\Finances\Domain\Category\CategoryException;
use App\Modules\Finances\Domain\Category\CategoryId;
use App\Modules\Finances\Domain\Category\CategoryRepository;
use App\Modules\Finances\Domain\User\UserContext;

final class GetOneCategoryByIdHandler
{
    private CategoryRepository $repository;
    private UserContext $userContext;

    public function __construct(CategoryRepository $repository, UserContext $userContext)
    {
        $this->repository = $repository;
        $this->userContext = $userContext;
    }

    public function __invoke(GetOneCategoryByIdQuery $query): CategoryDTO
    {
        $categoryId = CategoryId::fromInt($query->getCategoryId());

        $category = $this->repository->fetchById($categoryId, $this->userContext->getUserId());

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
