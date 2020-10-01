<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\UI\Http\Api\Category;

use App\Modules\Finances\Application\Category\CategoryReadModel;
use App\Modules\Finances\Application\Category\Query\FetchOneCategoryByIdQuery;
use App\Modules\Finances\Domain\Category\CategoryId;
use App\UI\Web\Action\Action;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class FetchOneCategoryByIdAction extends Action
{
    private CategoryReadModel $categoryReadModel;

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
