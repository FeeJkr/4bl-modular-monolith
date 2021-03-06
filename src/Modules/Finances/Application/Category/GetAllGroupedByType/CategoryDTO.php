<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\GetAllGroupedByType;

use DateTimeInterface;

final class CategoryDTO
{
    public function __construct(
        private int $id,
        private string $name,
        private string $type,
        private ?string $icon,
        private DateTimeInterface $createdAt
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }
}
