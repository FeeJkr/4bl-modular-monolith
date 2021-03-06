<?php
declare(strict_types=1);

namespace App\Web;

use App\Common\Infrastructure\Request\HttpRequestContext;
use App\Web\API\ApiHttpRequestContext;
use App\Web\MVC\WebHttpRequestContext;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\RequestContext;

final class HttpRequestContextFactory
{
    private RequestContext $requestContext;
    private ContainerInterface $container;

    public function __construct(RequestContext $requestContext, ContainerInterface $container)
    {
        $this->requestContext = $requestContext;
        $this->container = $container;
    }

    public function build(): HttpRequestContext
    {
        if (str_contains($this->requestContext->getPathInfo(), '/api/')) {
            return $this->container->get(ApiHttpRequestContext::class);
        }

        return $this->container->get(WebHttpRequestContext::class);
    }
}
