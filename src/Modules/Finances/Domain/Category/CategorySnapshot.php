<?php

declare(strict_types=1);

namespace App\Modules\Finances\Domain\Category;

final class CategorySnapshot
{
    public function __construct(
        private string $id,
        private string $userId,
        private string $name,
        private string $type,
        private string $icon,
    ){}

    public function getId(): string
    {
        return $this->id;
    }

    public function getUserId(): string
    {
        return $this->userId;
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