<?php

declare(strict_types=1);

namespace App\Modules\Finances\Domain\Category;

use JetBrains\PhpStorm\Pure;

final class Category
{
    public function __construct(
        private CategoryId $id,
        private string $name,
        private CategoryType $type,
        private string $icon,
    ){}

    #[Pure]
    public static function new(CategoryId $id, string $name, CategoryType $type, string $icon): self
    {
        return new self(
            $id,
            $name,
            $type,
            $icon,
        );
    }

    public function update(string $name, CategoryType $type, string $icon): void
    {
        $this->name = $name;
        $this->type = $type;
        $this->icon = $icon;
    }

    #[Pure]
    public function getSnapshot(): CategorySnapshot
    {
        return new CategorySnapshot(
            $this->id->toString(),
            $this->name,
            $this->type->getValue(),
            $this->icon,
        );
    }
}