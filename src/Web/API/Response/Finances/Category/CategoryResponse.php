<?php
declare(strict_types=1);

namespace App\Web\API\Response\Finances\Category;

use DateTimeInterface;

final class CategoryResponse
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

    public function getResponse(): array
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
