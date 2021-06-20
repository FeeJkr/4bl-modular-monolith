<?php

declare(strict_types=1);

namespace App\Modules\Finances\Application\Category;

final class CategoryDTO
{
    public function __construct(
        private string $id,
        private string $name,
        private string $type,
        private string $icon,
    ){}

    public static function createFromRow(array $row): self
    {
        return new self(
            $row['id'],
            $row['name'],
            $row['type'],
            $row['icon'],
        );
    }

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