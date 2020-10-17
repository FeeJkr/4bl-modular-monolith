<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\Update;

final class UpdateCategoryCommand
{
    private int $categoryId;
    private int $userId;
    private string $categoryName;
    private string $categoryType;
    private string $categoryIcon;

    public function __construct(
        int $categoryId,
        int $userId,
        string $categoryName,
        string $categoryType,
        string $categoryIcon
    ) {
        $this->categoryId = $categoryId;
        $this->userId = $userId;
        $this->categoryName = $categoryName;
        $this->categoryType = $categoryType;
        $this->categoryIcon = $categoryIcon;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getCategoryName(): string
    {
        return $this->categoryName;
    }

    public function getCategoryType(): string
    {
        return $this->categoryType;
    }

    public function getCategoryIcon(): string
    {
        return $this->categoryIcon;
    }
}
