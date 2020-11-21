<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\Create;

final class CreateCategoryCommand
{
    private string $categoryName;
    private string $categoryType;
    private ?string $categoryIcon;

    public function __construct(
        string $categoryName,
        string $categoryType,
        ?string $categoryIcon
    ) {
        $this->categoryName = $categoryName;
        $this->categoryType = $categoryType;
        $this->categoryIcon = $categoryIcon;
    }

    public function getCategoryName(): string
    {
        return $this->categoryName;
    }

    public function getCategoryType(): string
    {
        return $this->categoryType;
    }

    public function getCategoryIcon(): ?string
    {
        return $this->categoryIcon;
    }
}
