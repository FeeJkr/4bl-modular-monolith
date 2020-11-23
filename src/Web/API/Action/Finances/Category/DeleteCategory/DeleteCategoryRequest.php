<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Category\DeleteCategory;

use App\Web\API\Action\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class DeleteCategoryRequest extends Request
{
    private int $categoryId;

    public function __construct(int $categoryId)
    {
        $this->categoryId = $categoryId;
    }

    public static function createFromServerRequest(ServerRequest $request): self
    {
        $categoryId = $request->get('id');

        Assert::lazy()
            ->that($categoryId, 'id')->notEmpty()
            ->verifyNow();

        return new self(
            (int) $categoryId
        );
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }
}
