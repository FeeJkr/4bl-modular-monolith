<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\User;

use App\Modules\Accounts\Domain\DomainException;
use Exception;
use JetBrains\PhpStorm\Pure;

abstract class ApplicationException extends Exception
{
    #[Pure]
    public static function fromDomainException(DomainException $exception): static
    {
        return new static($exception->getMessage(), $exception->getCode(), $exception);
    }
}
