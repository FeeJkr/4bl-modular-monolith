<?php
declare(strict_types=1);

namespace App\Web\API\Request;

use Symfony\Component\HttpFoundation\Request as ServerRequest;

abstract class Request
{
    abstract public static function createFromServerRequest(ServerRequest $request): self;

    final protected static function extendUserTokenFromRequest(ServerRequest $request): ?string
    {
        return $request->headers->get('X-Authorization');
    }
}
