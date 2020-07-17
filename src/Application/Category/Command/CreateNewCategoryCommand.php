<?php
declare(strict_types=1);

namespace App\Application\Category\Command;

use App\SharedKernel\Category\CategoryType;
use App\SharedKernel\User\UserId;

final class CreateNewCategoryCommand
{
    private $userId;
    private $categoryName;
    private $categoryType;
    private $categoryIcon;

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
