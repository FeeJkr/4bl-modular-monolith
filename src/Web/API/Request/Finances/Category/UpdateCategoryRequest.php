<?php
declare(strict_types=1);

namespace App\Web\API\Request\Finances\Category;

use App\Web\API\Request\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class UpdateCategoryRequest extends Request
{
    private int $categoryId;
    private string $categoryName;
    private string $categoryType;
    private string $categoryIcon;
    private string $userToken;

    public function __construct(
        int $categoryId,
        string $categoryName,
        string $categoryType,
        string $categoryIcon,
        string $userToken
    ) {
        $this->categoryId = $categoryId;
        $this->categoryName = $categoryName;
        $this->categoryType = $categoryType;
        $this->categoryIcon = $categoryIcon;
        $this->userToken = $userToken;
    }

    public static function createFromServerRequest(ServerRequest $request): self
    {
        $categoryId = $request->get('id');
        $categoryName = $request->get('name');
        $categoryType = $request->get('type');
        $categoryIcon = $request->get('icon');
        $userToken = self::extendUserTokenFromRequest($request);

        Assert::lazy()
            ->that($categoryId, 'id')->notEmpty()
            ->that($categoryName, 'name')->notEmpty()
            ->that($categoryType, 'type')->notEmpty()
            ->that($categoryIcon, 'icon')->notEmpty()
            ->that($userToken, 'user_token')->notEmpty()
            ->verifyNow();

        return new self(
            (int) $categoryId,
            $categoryName,
            $categoryType,
            $categoryIcon,
            $userToken
        );
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

    public function getUserToken(): string
    {
        return $this->userToken;
    }
}
