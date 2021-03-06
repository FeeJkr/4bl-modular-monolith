<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\GetUserByToken;

final class UserDTO
{
    public function __construct(
        private string $id,
        private string $email,
        private string $username,
        private string $token
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
