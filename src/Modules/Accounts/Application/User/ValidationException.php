<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\User;

use JetBrains\PhpStorm\Pure;

final class ValidationException extends ApplicationException
{
    private const INVALID_USERNAME_MESSAGE = 'Username is invalid.';
    private const INVALID_EMAIL_MESSAGE = 'Email is invalid.';
    private const INVALID_PASSWORD_MESSAGE = 'Password is invalid. Length must be more then 8 chars and less then 15 chars';

    #[Pure]
    public static function invalidUsername(): self
    {
        return new self(self::INVALID_USERNAME_MESSAGE);
    }

    #[Pure]
    public static function invalidEmail(): self
    {
        return new self(self::INVALID_EMAIL_MESSAGE);
    }

    #[Pure]
    public static function invalidPassword(): self
    {
        return new self(self::INVALID_PASSWORD_MESSAGE);
    }
}
