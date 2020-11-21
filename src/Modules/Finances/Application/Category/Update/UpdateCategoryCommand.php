<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\Update;

final class UpdateCategoryCommand
{
    private int $categoryId;
    private string $categoryName;
    private string $categoryType;
    private string $categoryIcon;

    public function __construct(
        int $categoryId,
        string $categoryName,
        string $categoryType,
        string $categoryIcon
    ) {
        $this->categoryId = $categoryId;
        $this->categoryName = $categoryName;
        $this->categoryType = $categoryType;
        $this->categoryIcon = $categoryIcon;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
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
