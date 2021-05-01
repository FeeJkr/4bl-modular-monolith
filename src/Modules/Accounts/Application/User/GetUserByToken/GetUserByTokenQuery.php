<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\GetUserByToken;

use App\Common\Application\Query\Query;

final class GetUserByTokenQuery implements Query
{
    public function __construct(private string $token) {}

    public function getToken(): string
    {
        return $this->token;
    }
}
