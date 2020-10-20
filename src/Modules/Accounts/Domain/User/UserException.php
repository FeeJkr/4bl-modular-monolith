<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Domain\User;

use Exception;

final class UserException extends Exception
{
    public static function withInvalidCredentials(): self
    {
        return new self('Invalid credentials.');
    }

    public static function notFoundByToken(Token $token): self
    {
        return new self(sprintf('User with token %s not found.', $token->toString()));
    }

    public static function alreadyExists(): self
    {
        return new self('Users with given email or username already exists');
    }
}
