<?php
declare(strict_types=1);

namespace App\UI\Web\Action\Category;

use App\Category\ReadModel\CategoryReadModel;
use App\Category\ReadModel\Query\FetchOneCategoryByIdQuery;
use App\Category\SharedKernel\CategoryId;
use App\UI\Web\Action\Action;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class FetchOneCategoryByIdAction extends Action
{
    private $categoryReadModel;

    public function __construct(CategoryReadModel $categoryReadModel)
    {
        $this->categoryReadModel = $categoryReadModel;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $query = new FetchOneCategoryByIdQuery(
            $request->get('user_id'),
            CategoryId::fromInt((int) $request->get('id'))
        );

        return $this->json($this->categoryReadModel->fetchOneById($query));
    }
}
