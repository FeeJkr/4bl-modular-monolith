<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Category\GetOneCategoryById;

use App\Modules\Finances\Application\Category\GetOneById\CategoryDTO;
use DateTimeInterface;

final class GetOneCategoryByIdResponse
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

    public static function createFromCategory(CategoryDTO $categoryDTO): self
    {
        return new self(
            $categoryDTO->getId(),
            $categoryDTO->getUserId(),
            $categoryDTO->getName(),
            $categoryDTO->getType(),
            $categoryDTO->getIcon(),
            $categoryDTO->getCreatedAt()
        );
    }

    public function getResponse(): array
    {
        return [
            'id' => $this->id,
            'userId' => $this->userId,
            'name' => $this->name,
            'type' => $this->type,
            'icon' => $this->icon,
            'createdAt' => $this->createdAt->getTimestamp(),
        ];
    }
}
