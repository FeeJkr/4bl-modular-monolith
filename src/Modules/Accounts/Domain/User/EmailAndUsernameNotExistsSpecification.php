<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Domain\User;

final class EmailAndUsernameNotExistsSpecification
{
    public function __construct(private UserRepository $repository){}

    public function isSatisfiedBy(string $email, string $username): bool
    {
        return ! $this->repository->existsByEmailOrUsername($email, $username);
    }
}