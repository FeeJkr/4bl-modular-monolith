<?php

declare(strict_types=1);

namespace App\Web\API\Action\Finances\Category\Create;

use App\Web\API\Action\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class CreateCategoryRequest extends Request
{
    public function __construct(private string $name, private string $type, private string $icon){}

    public static function fromRequest(ServerRequest $request): Request
    {
        $requestData = $request->toArray();

        $name = $requestData['name'];
        $type = $requestData['type'];
        $icon = $requestData['icon'];

        Assert::lazy()
            ->that($name, 'name')->notEmpty()->maxLength(254)
            ->that($type, 'type')->notEmpty()
            ->that($icon, 'icon')->notEmpty()->maxLength(254)
            ->verifyNow();

        return new self(
            $name,
            $type,
            $icon,
        );
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }
}