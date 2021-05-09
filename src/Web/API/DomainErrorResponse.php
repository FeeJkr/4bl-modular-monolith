<?php

declare(strict_types=1);

namespace App\Web\API;

use Assert\InvalidArgumentException;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use Throwable;
use function array_map;

final class DomainErrorResponse
{
	#[ArrayShape(['message' => "string"])]
	public static function getResponse(Throwable $exception): array
    {
    	return [
			[
				'message' => $exception->getMessage(),
			],
		];
    }
}
