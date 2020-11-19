<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\GetUserByToken;

final class UserDTO
{
    private int $id;
    private string $email;
    private string $username;
    private string $password;
    private string $token;

    public function __construct(int $id, string $email, string $username, string $password, string $token)
    {
        $this->id = $id;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
        $this->token = $token;
    }

    public function getId(): int
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

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
