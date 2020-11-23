<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Category\CreateCategory;

use App\Web\API\Action\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class CreateCategoryRequest extends Request
{
    private string $categoryName;
    private string $categoryType;
    private string $categoryIcon;

    public function __construct(string $categoryName, string $categoryType, string $categoryIcon)
    {
        $this->categoryName = $categoryName;
        $this->categoryType = $categoryType;
        $this->categoryIcon = $categoryIcon;
    }

    public static function createFromServerRequest(ServerRequest $request): self
    {
        $categoryName = $request->get('name');
        $categoryType = $request->get('type');
        $categoryIcon = $request->get('icon');

        Assert::lazy()
            ->that($categoryName, 'name')->notEmpty()
            ->that($categoryType, 'type')->notEmpty()
            ->that($categoryIcon, 'icon')->notEmpty()
            ->verifyNow();

        return new self(
            $categoryName,
            $categoryType,
            $categoryIcon
        );
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
