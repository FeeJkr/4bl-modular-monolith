<?php
declare(strict_types=1);

namespace App\ReadModel\Category;

use App\SharedKernel\Category\CategoryId;
use App\SharedKernel\Category\CategoryType;
use App\SharedKernel\User\UserId;
use DateTime;

final class CategoryDTOFactory
{
    public static function createFromArray(array $category): CategoryDTO
    {
        return new CategoryDTO(
            new CategoryId($category['id']),
            new UserId($category['user_id']),
            $category['name'],
            new CategoryType($category['type']),
            $category['icon'],
            DateTime::createFromFormat('Y-m-d H:i:s', $category['created_at'])
        );
    }
}
