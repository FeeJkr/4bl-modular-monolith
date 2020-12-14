<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\Register;

final class RegisterUserCommand
{
    public function __construct(private string $email, private string $username, private string $password) {}

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
