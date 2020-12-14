<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\GetAll;

use DateTimeInterface;

final class CategoryDTO
{
    public function __construct(
        private int $id,
        private int $userId,
        private string $name,
        private string $type,
        private ?string $icon,
        private DateTimeInterface $createdAt
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
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

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }
}
