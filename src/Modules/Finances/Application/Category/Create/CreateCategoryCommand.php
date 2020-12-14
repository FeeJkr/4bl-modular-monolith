<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\Create;

final class CreateCategoryCommand
{
    public function __construct(
        private string $name,
        private string $type,
        private ?string $icon
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }
}
