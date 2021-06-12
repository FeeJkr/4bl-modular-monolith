<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Domain\User;

final class ValidPasswordSpecification
{
    public function __construct(private PasswordManager $passwordManager){}

    public function isSatisfiedBy(string $plainPassword, string $hashedPassword): bool
    {
        return $this->passwordManager->isValid($plainPassword, $hashedPassword);
    }
}