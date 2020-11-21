<?php
declare(strict_types=1);

namespace App\Web\MVC;

use App\Common\Infrastructure\Request\HttpRequestContext;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class WebHttpRequestContext implements HttpRequestContext
{
    private SessionInterface $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function getUserToken(): string
    {
        return $this->session->get('user.token', '');
    }
}
