<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\Domain\User;

use App\Modules\Accounts\Domain\User\PasswordManager;

final class PHPBuildInPasswordManager implements PasswordManager
{
    public function hash(string $plainPassword): string
    {
        return password_hash($plainPassword, PASSWORD_BCRYPT);
    }

    public function isValid(string $plainPassword, string $hashedPassword): bool
    {
        return password_verify($plainPassword, $hashedPassword);
    }
}
