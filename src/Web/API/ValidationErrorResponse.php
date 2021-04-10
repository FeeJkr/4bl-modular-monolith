<?php
declare(strict_types=1);

namespace App\Web\API;

use Assert\InvalidArgumentException;
use JetBrains\PhpStorm\Pure;
use function array_map;

final class ValidationErrorResponse
{
	public static function getResponse(InvalidArgumentException ...$errors): array
    {
    	return array_map(static fn (InvalidArgumentException $error) => [
			'propertyPath' => $error->getPropertyPath(),
    		'message' => $error->getMessage(),
		], $errors);
    }
}
