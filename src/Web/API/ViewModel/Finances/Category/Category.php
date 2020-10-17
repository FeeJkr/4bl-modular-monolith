<?php
declare(strict_types=1);

namespace App\Web\API\ViewModel\Finances\Category;

use DateTimeInterface;
use JsonSerializable;

final class Category implements JsonSerializable
{
    private int $id;
    private int $userId;
    private string $name;
    private string $type;
    private ?string $icon;
    private DateTimeInterface $createdAt;

    public function __construct(
        int $id,
        int $userId,
        string $name,
        string $type,
        ?string $icon,
        DateTimeInterface $createdAt
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->name = $name;
        $this->type = $type;
        $this->icon = $icon;
        $this->createdAt = $createdAt;
    }

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

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'user_id' => $this->userId,
            'name' => $this->name,
            'type' => $this->type,
            'icon' => $this->icon,
            'created_at' => $this->createdAt->getTimestamp(),
        ];
    }
}
