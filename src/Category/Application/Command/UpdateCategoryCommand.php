<?php
declare(strict_types=1);

namespace App\Category\Application\Command;

use App\Category\SharedKernel\CategoryId;
use App\Category\SharedKernel\CategoryType;
use App\SharedKernel\User\UserId;

final class UpdateCategoryCommand
{
    private $categoryId;
    private $userId;
    private $categoryName;
    private $categoryType;
    private $categoryIcon;

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
