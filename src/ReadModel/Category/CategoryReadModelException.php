<?php
declare(strict_types=1);

namespace App\ReadModel\Category;

use App\SharedKernel\Category\CategoryId;
use Exception;

final class CategoryReadModelException extends Exception
{
    public static function notFoundById(CategoryId $categoryId): self
    {
        return new self(
            sprintf('Category with ID %s not found.', $categoryId->toInt())
        );
    }
}
