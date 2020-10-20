<?php
declare(strict_types=1);

namespace App\Web\API\Service\Accounts\User;

use Exception;
use Throwable;

final class UserRegistrationErrorException extends Exception
{
    public static function create(Throwable $exception): self
    {
        return new self(
            $exception->getMessage(),
            $exception->getCode(),
            $exception
        );
    }
}
