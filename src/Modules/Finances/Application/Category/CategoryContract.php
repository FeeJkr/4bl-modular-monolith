<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category;

use App\Modules\Finances\Application\Category\Create\CreateCategoryCommand;
use App\Modules\Finances\Application\Category\Delete\DeleteCategoryCommand;
use App\Modules\Finances\Application\Category\GetAll\CategoriesCollection;
use App\Modules\Finances\Application\Category\GetAll\GetAllCategoriesQuery;
use App\Modules\Finances\Application\Category\GetOneById\CategoryDTO;
use App\Modules\Finances\Application\Category\GetOneById\GetOneCategoryByIdQuery;
use App\Modules\Finances\Application\Category\Update\UpdateCategoryCommand;

interface CategoryContract
{
    public function createCategory(CreateCategoryCommand $command): void;
    public function deleteCategory(DeleteCategoryCommand $command): void;
    public function updateCategory(UpdateCategoryCommand $command): void;

    public function getAllCategories(GetAllCategoriesQuery $query): CategoriesCollection;
    public function getOneCategoryById(GetOneCategoryByIdQuery $query): CategoryDTO;
}
