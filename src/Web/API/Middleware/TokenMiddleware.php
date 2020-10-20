<?php
declare(strict_types=1);

namespace App\Web\API\Middleware;

use App\Modules\Accounts\Application\User\TokenManager;
use App\Modules\Accounts\Domain\User\Token;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\Accounts\User\RegisterUserAction;
use App\Web\API\Action\Accounts\User\SignInUserAction;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use function get_class;
use function in_array;

final class TokenMiddleware implements EventSubscriberInterface
{
    private TokenManager $tokenManager;

    protected array $allowedActions = [
        SignInUserAction::class,
        RegisterUserAction::class,
    ];

    public function __construct(TokenManager $tokenManager)
    {
        $this->tokenManager = $tokenManager;
    }

    public function onKernelController(ControllerEvent $event): void
    {
        if ($event->getController() instanceof AbstractAction) {
            if (in_array(get_class($event->getController()), $this->allowedActions, true)) {
                return;
            }

            $token = new Token($event->getRequest()->headers->get('X-Authorization'));

            if ($this->tokenManager->isValid($token)) {
                return;
            }

            $event->setController(static function (): Response {
                return new JsonResponse(['error' => 'Authentication error.'], Response::HTTP_FORBIDDEN);
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
