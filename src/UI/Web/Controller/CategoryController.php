<?php
declare(strict_types=1);

namespace App\UI\Web\Controller;

use App\ReadModel\Category\CategoryReadModel;
use App\ReadModel\Category\FetchAllQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class CategoryController extends AbstractController
{
    private $categoryReadModel;

    public function __construct(CategoryReadModel $categoryReadModel)
    {
        $this->categoryReadModel = $categoryReadModel;
    }

    public function index(Request $request): JsonResponse
    {
        $query = new FetchAllQuery($request->get('user_id'));

        return $this->json(
            $this->categoryReadModel->fetchAll($query)->toArray()
        );
    }
}
