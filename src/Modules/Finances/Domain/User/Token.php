<?php
declare(strict_types=1);

namespace App\Modules\Finances\Domain\User;

final class Token
{
    private string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function toString(): string
    {
        return $this->token;
    }
}
