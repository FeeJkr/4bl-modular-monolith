<?php
declare(strict_types=1);

namespace App\Web\API;

use App\Common\Infrastructure\Request\HttpRequestContext;
use RuntimeException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class ApiHttpRequestContext implements HttpRequestContext
{
    private Request $request;

    public function __construct(RequestStack $requestStack)
    {
        $request = $requestStack->getCurrentRequest();

        if ($request === null) {
            throw new RuntimeException('Error in API Http Request Context');
        }

        $this->request = $request;
    }

    public function getUserToken(): string
    {
        $token = $this->request->headers->get('Authorization');

        if ($this->isBearerToken($token)) {
            $token = substr($token, 7);
        }

        return $token;
    }

    private function isBearerToken(string $token): bool
    {
        return str_contains($token, 'Bearer ');
    }
}
