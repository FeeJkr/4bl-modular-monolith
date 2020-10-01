<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\UI\Http\Api\Category;

use App\Modules\Finances\Application\Category\CategoryReadModel;
use App\Modules\Finances\Application\Category\Query\FetchAllCategoriesQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class FetchAllCategoriesAction extends AbstractController
{
    private CategoryReadModel $categoryReadModel;

    public function __construct(CategoryReadModel $categoryReadModel)
    {
        $this->categoryReadModel = $categoryReadModel;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $query = new FetchAllCategoriesQuery(
            $request->get('user_id')
        );

        return $this->json($this->categoryReadModel->fetchAll($query)->toArray());
    }
}
