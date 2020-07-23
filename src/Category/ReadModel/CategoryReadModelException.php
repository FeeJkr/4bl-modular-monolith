<?php
declare(strict_types=1);

namespace App\Category\ReadModel;

use App\Category\SharedKernel\CategoryId;
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
