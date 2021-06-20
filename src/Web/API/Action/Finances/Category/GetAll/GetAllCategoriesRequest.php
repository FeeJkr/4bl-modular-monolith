<?php

declare(strict_types=1);

namespace App\Web\API\Action\Finances\Category\GetAll;

use App\Web\API\Action\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class GetAllCategoriesRequest extends Request
{
    public function __construct(private ?string $type){}

    public static function fromRequest(ServerRequest $request): Request
    {
        $type = $request->get('type');

        Assert::lazy()
            ->that($type, 'type')->nullOr()->string()
            ->verifyNow();

        return new self($type);
    }

    public function getType(): ?string
    {
        return $this->type;
    }
}