<?php
declare(strict_types=1);

namespace App\Web\API;

use Assert\InvalidArgumentException;
use function array_map;

final class ValidationErrorResponse
{
    public static function getResponse(InvalidArgumentException ...$errors): array
    {
        return array_map(static function (InvalidArgumentException $error): array {
            return [
                'message' => $error->getMessage(),
                'value' => $error->getValue(),
                'propertyPath' => $error->getPropertyPath(),
            ];
        }, $errors);
    }
}
