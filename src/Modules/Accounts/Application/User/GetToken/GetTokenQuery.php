<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\GetToken;

final class GetTokenQuery
{
    public function __construct(private string $email) {}

    public function getEmail(): string
    {
        return $this->email;
    }
}
