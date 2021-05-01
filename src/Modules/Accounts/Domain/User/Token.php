<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Domain\User;

use JetBrains\PhpStorm\Pure;

final class Token
{
    public function __construct(private ?string $token) {}

    #[Pure]
    public static function nullInstance(): self
    {
        return new self(null);
    }

    public function toString(): ?string
    {
        return $this->token;
    }

    public function isNull(): bool
    {
        return $this->token === null;
    }
}
