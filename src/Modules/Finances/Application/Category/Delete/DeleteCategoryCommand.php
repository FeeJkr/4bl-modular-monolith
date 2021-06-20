<?php

declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\Delete;

use App\Common\Application\Command\Command;

final class DeleteCategoryCommand implements Command
{
    public function __construct(private string $id){}

    public function getId(): string
    {
        return $this->id;
    }
}