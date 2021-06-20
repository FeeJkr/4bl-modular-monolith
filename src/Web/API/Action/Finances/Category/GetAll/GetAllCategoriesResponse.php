<?php

declare(strict_types=1);

namespace App\Web\API\Action\Finances\Category\GetAll;

use App\Modules\Finances\Application\Category\CategoryDTO;
use App\Modules\Finances\Application\Category\CategoryDTOCollection;
use App\Web\API\Action\Response;

final class GetAllCategoriesResponse extends Response
{
    public static function respond(CategoryDTOCollection $categories): self
    {
        return new self(
            array_map(static fn(CategoryDTO $category) => [
                'id' => $category->getId(),
                'name' => $category->getName(),
                'type' => $category->getType(),
                'icon' => $category->getIcon(),
            ], $categories->toArray())
        );
    }
}