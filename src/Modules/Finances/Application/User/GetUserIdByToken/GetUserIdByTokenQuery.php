<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\User\GetUserIdByToken;

final class GetUserIdByTokenQuery
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
