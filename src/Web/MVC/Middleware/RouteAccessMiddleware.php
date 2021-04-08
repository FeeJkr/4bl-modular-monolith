<?php
declare(strict_types=1);

namespace App\Web\MVC\Middleware;

use App\Common\Infrastructure\Request\HttpRequestContext;
use App\Modules\Accounts\Application\User\TokenManager;
use App\Modules\Accounts\Domain\User\Token;
use App\Web\MVC\Controller\AbstractController;
use App\Web\MVC\Controller\Accounts\Auth\AuthController;
use App\Web\MVC\Controller\Invoices\InvoiceController;
use App\Web\MVC\Controller\WebhookController;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class RouteAccessMiddleware implements EventSubscriberInterface
{
    public function __construct(
        private TokenManager $tokenManager,
        private UrlGeneratorInterface $urlGenerator,
        private HttpRequestContext $requestContext,
        private string $invoiceToken,
    ) {}

    #[ArrayShape([KernelEvents::CONTROLLER => "string"])]
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }

    public function onKernelController(ControllerEvent $event): void
    {
        $controller = $event->getController();

//        if (is_array($controller) && $controller[0] instanceof AbstractController) {
//            if ($this->isWebhookAction($controller)) {
//                return;
//            }
//
//            if ($this->isProtectedByTokenAction($controller)) {
//                $this->processProtectedByTokenAction($event);
//
//                return;
//            }
//
//            if ($this->isGuestAction($controller)) {
//                $this->processGuestAction($event);
//
//                return;
//            }
//
//            $this->processProtectedByAuthenticationAction($event);
//        }
    }

    private function isWebhookAction(array $controller): bool
    {
        return $controller[0] instanceof WebhookController;
    }

    private function isProtectedByTokenAction(array $controller): bool
    {
        return $controller[0] instanceof InvoiceController;
    }

    private function processProtectedByTokenAction(ControllerEvent $event): void
    {
        $token = $event->getRequest()->get('token');

        if ($token === $this->invoiceToken) {
            return;
        }

        $event->setController(function (): Response {
            return new RedirectResponse($this->urlGenerator->generate('dashboard'));
        });
    }

    private function isGuestAction(array $controller): bool
    {
        return $controller[0] instanceof AuthController;
    }

    private function processGuestAction(ControllerEvent $event): void
    {
        $token = new Token($this->requestContext->getUserToken());

        if ($this->tokenManager->isValid($token)) {
            $event->setController(function (): Response {
                return new RedirectResponse($this->urlGenerator->generate('dashboard'));
            });

            return;
        }
    }

    private function processProtectedByAuthenticationAction(ControllerEvent $event): void
    {
        $token = new Token($this->requestContext->getUserToken());

        if ($this->tokenManager->isValid($token)) {
            return;
        }

        $event->setController(function (): Response {
            return new RedirectResponse($this->urlGenerator->generate('accounts.user.sign-in'));
        });
    }
}
