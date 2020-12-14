<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\SignOut;

final class SignOutUserCommand
{
    public function __construct(private string $token) {}

    public function getToken(): string
    {
        return $this->token;
    }
}
