<?php

declare(strict_types=1);

namespace App\Web\API\Action\Finances\Category\GetById;

use App\Modules\Finances\Application\Category\CategoryDTO;
use App\Web\API\Action\Response;

final class GetCategoryByIdResponse extends Response
{
    public static function respond(CategoryDTO $category): self
    {
        return new self([
            'id' => $category->getId(),
            'name' => $category->getName(),
            'type' => $category->getType(),
            'icon' => $category->getIcon(),
        ]);
    }
}