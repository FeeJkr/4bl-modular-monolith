<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\User\FetchUserIdByToken;

final class FetchUserIdByTokenQuery
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
