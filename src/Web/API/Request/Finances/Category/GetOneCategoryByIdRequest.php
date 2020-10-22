<?php
declare(strict_types=1);

namespace App\Web\API\Request\Finances\Category;

use App\Web\API\Request\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class GetOneCategoryByIdRequest extends Request
{
    private int $categoryId;
    private string $userToken;

    public function __construct(int $categoryId, string $userToken)
    {
        $this->categoryId = $categoryId;
        $this->userToken = $userToken;
    }

    public static function createFromServerRequest(ServerRequest $request): self
    {
        $categoryId = $request->get('id');
        $userToken = self::extendUserTokenFromRequest($request);

        Assert::lazy()
            ->that($categoryId, 'id')->notEmpty()
            ->that($userToken, 'user_token')->notEmpty()
            ->verifyNow();

        return new self(
            (int) $categoryId,
            $userToken
        );
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function getUserToken(): string
    {
        return $this->userToken;
    }
}
