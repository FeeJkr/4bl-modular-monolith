<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Domain\User;

use DateTimeImmutable;

final class User
{
    public function __construct(
        private UserId $id,
        private string $email,
        private string $username,
        private string $password,
        private Token $token,
        private DateTimeImmutable $createdAt,
        private ?DateTimeImmutable $updatedAt
    ) {}

    public static function register(string $email, string $username, string $password): self
    {
        return new self(
            UserId::generate(),
            $email,
            $username,
            $password,
            Token::nullInstance(),
            new DateTimeImmutable(),
            null
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
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

}
