<?php
declare(strict_types=1);

namespace App\DomainModel\Category;

use App\SharedKernel\Category\CategoryId;
use App\SharedKernel\Category\CategoryType;
use App\SharedKernel\User\UserId;
use DateTimeInterface;

final class Category
{
    private const DEFAULT_ICON = 'home';

    private $id;
    private $userId;
    private $name;
    private $type;
    private $icon;

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
