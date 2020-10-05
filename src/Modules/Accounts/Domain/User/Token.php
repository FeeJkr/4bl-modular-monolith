<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Domain\User;

final class Token
{
    private ?string $token;

    public function __construct(?string $token)
    {
        $this->token = $token;
    }

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
