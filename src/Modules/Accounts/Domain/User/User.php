<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Domain\User;

final class User
{
    private UserId $id;
    private string $email;
    private string $username;
    private string $password;
    private Token $token;

    public function __construct(UserId $id, string $email, string $username, string $password, Token $token)
    {
        $this->id = $id;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
        $this->token = $token;
    }

    public static function register(string $email, string $username, string $password): self
    {
        return new self(
            UserId::nullInstance(),
            $email,
            $username,
            $password,
            Token::nullInstance()
        );
    }

    public function signIn(Token $token): void
    {
        $this->token = $token;
    }

    public function signOut(): void
    {
        $this->token = new Token(null);
    }

    public function getId(): UserId
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

    public function getToken(): Token
    {
        return $this->token;
    }
}
