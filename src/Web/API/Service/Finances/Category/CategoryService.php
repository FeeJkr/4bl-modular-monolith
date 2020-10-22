<?php
declare(strict_types=1);

namespace App\Web\API\Service\Finances\Category;

use App\Web\API\Request\Finances\Category\CreateCategoryRequest;
use App\Web\API\Request\Finances\Category\DeleteCategoryRequest;
use App\Web\API\Request\Finances\Category\GetAllCategoriesRequest;
use App\Web\API\Request\Finances\Category\GetOneCategoryByIdRequest;
use App\Web\API\Request\Finances\Category\UpdateCategoryRequest;
use App\Web\API\ViewModel\Finances\Category\Category;

interface CategoryService
{
    public function createCategory(CreateCategoryRequest $request): void;
    public function deleteCategory(DeleteCategoryRequest $request): void;
    public function updateCategory(UpdateCategoryRequest $request): void;
    public function getAllCategories(GetAllCategoriesRequest $request): array;
    public function getOneCategoryById(GetOneCategoryByIdRequest $request): Category;
}
