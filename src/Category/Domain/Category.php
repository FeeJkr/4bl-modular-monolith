<?php
declare(strict_types=1);

namespace App\Category\Domain;

use App\Category\SharedKernel\CategoryId;
use App\Category\SharedKernel\CategoryType;
use App\SharedKernel\User\UserId;

final class Category
{
    private const DEFAULT_ICON = 'home';

    private CategoryId $id;
    private UserId $userId;
    private string $name;
    private CategoryType $type;
    private ?string $icon;

    public function __construct(
        CategoryId $id,
        UserId $userId,
        string $name,
        CategoryType $type,
        ?string $icon
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->name = $name;
        $this->type = $type;
        $this->icon = $icon;
    }

    public static function createNew(
        UserId $userId,
        string $name,
        CategoryType $type,
        ?string $icon
    ): self {
        return new self(
            CategoryId::nullInstance(),
            $userId,
            $name,
            $type,
            $icon
        );
    }

    public function update(string $name, CategoryType $type, string $icon): void
    {
        if ($this->name !== $name) {
            $this->name = $name;
        }

        if (! $this->type->equals($type)) {
            $this->type = $type;
        }

        if ($this->icon !== $icon) {
            $this->icon = $icon;
        }
    }

    public function getId(): CategoryId
    {
        return $this->id;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): CategoryType
    {
        return $this->type;
    }

    public function getIcon(): string
    {
        if ($this->icon === null) {
            return self::DEFAULT_ICON;
        }

        return $this->icon;
    }
}
