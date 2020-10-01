<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\Command;

use App\Common\User\UserId;
use App\Modules\Finances\Domain\Category\CategoryType;

final class CreateCategoryCommand
{
    private UserId $userId;
    private string $categoryName;
    private CategoryType $categoryType;
    private ?string $categoryIcon;

    public function __construct(
        UserId $userId,
        string $categoryName,
        CategoryType $categoryType,
        ?string $categoryIcon
    ) {
        $this->userId = $userId;
        $this->categoryName = $categoryName;
        $this->categoryType = $categoryType;
        $this->categoryIcon = $categoryIcon;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getCategoryName(): string
    {
        return $this->categoryName;
    }

    public function getCategoryType(): CategoryType
    {
        return $this->categoryType;
    }

    public function getCategoryIcon(): ?string
    {
        return $this->categoryIcon;
    }
}
