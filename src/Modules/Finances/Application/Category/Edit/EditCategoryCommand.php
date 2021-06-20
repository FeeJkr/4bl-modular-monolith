<?php

declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\Edit;

use App\Common\Application\Command\Command;

final class EditCategoryCommand implements Command
{
    public function __construct(
        private string $id,
        private string $name,
        private string $type,
        private string $icon,
    ){}

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }
}