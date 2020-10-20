<?php
declare(strict_types=1);

namespace App\Web\MVC\Middleware;

use App\Modules\Accounts\Application\User\TokenManager;
use App\Modules\Accounts\Domain\User\Token;
use App\Web\MVC\Controller\AbstractController;
use App\Web\MVC\Controller\Accounts\Auth\AuthController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class TokenMiddleware implements EventSubscriberInterface
{
    private TokenManager $tokenManager;
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(TokenManager $tokenManager, UrlGeneratorInterface $urlGenerator)
    {
        $this->tokenManager = $tokenManager;
        $this->urlGenerator = $urlGenerator;
    }

    public function onKernelController(ControllerEvent $event): void
    {
        $controller = $event->getController();

        if (is_array($controller) && $controller[0] instanceof AbstractController) {
            $isAllowedAction = $controller[0] instanceof AuthController;
            $token = new Token($event->getRequest()->getSession()->get('user.token'));

            if ($this->tokenManager->isValid($token)) {
                if ($isAllowedAction) {
                    $event->setController(function (): Response {
                        return new RedirectResponse($this->urlGenerator->generate('dashboard'));
                    });
                }

                return;
            }

            // if token is invalid and we in allowed action
            if ($isAllowedAction) {
                return;
            }

            // if token is invalid and we in blocked action
            $event->setController(function (): Response {
                return new RedirectResponse($this->urlGenerator->generate('accounts.user.sign-in'));
            });
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
