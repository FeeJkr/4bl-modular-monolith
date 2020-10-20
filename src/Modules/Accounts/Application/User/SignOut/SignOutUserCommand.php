<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\SignOut;

final class SignOutUserCommand
{
    private string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
