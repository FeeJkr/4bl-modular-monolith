<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Domain\User;

interface UserRepository
{
    public function store(User $user): void;
    public function save(User $user): void;
    public function fetchByEmail(string $email): ?User;
    public function existsByEmailOrUsername(string $email, string $username): bool;
    public function fetchByToken(Token $token): User;
}
