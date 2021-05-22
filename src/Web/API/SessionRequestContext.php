<?php

declare(strict_types=1);

namespace App\Web\API;

use App\Common\Infrastructure\Request\HttpRequestContext;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class SessionRequestContext implements HttpRequestContext
{
    public function __construct(private SessionInterface $session){}

    public function getUserToken(): string
    {
        return $this->session->get('user.token', '');
    }
}
