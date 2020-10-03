<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Category\Update;

use App\Modules\Finances\Domain\Category\CategoryId;
use App\Modules\Finances\Domain\Category\CategoryType;
use App\Modules\Finances\Domain\User\UserId;

final class UpdateCategoryCommand
{
    private CategoryId $categoryId;
    private UserId $userId;
    private string $categoryName;
    private CategoryType $categoryType;
    private string $categoryIcon;

    public function __construct(
        CategoryId $categoryId,
        UserId $userId,
        string $categoryName,
        CategoryType $categoryType,
        string $categoryIcon
    ) {
        $this->categoryId = $categoryId;
        $this->userId = $userId;
        $this->categoryName = $categoryName;
        $this->categoryType = $categoryType;
        $this->categoryIcon = $categoryIcon;
    }

    public function getCategoryId(): CategoryId
    {
        return $this->categoryId;
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

    public function getCategoryIcon(): string
    {
        return $this->categoryIcon;
    }
}
