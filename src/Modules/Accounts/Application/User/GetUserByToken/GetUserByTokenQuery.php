<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\GetUserByToken;

final class GetUserByTokenQuery
{
    public function __construct(private string $token) {}

    public function getToken(): string
    {
        return $this->token;
    }
}
