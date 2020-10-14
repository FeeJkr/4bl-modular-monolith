<?php
declare(strict_types=1);

namespace App\Modules\Finances\Domain\User;

use Exception;

final class UserException extends Exception
{
    public static function notFoundByToken(Token $token): self
    {
        return new self(sprintf('User with token "%s" not found', $token->toString()));
    }
}
