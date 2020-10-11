<?php
declare(strict_types=1);

namespace App\Web\API\Middleware;

use App\Modules\Accounts\Application\User\TokenManager;
use App\Modules\Accounts\Domain\User\Token;
use App\Web\API\Action\Accounts\User\RegisterUserAction;
use App\Web\API\Action\Accounts\User\SignInUserAction;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use function in_array;

final class TokenMiddleware implements EventSubscriberInterface
{
    private TokenManager $tokenManager;

    protected array $actions = [
        SignInUserAction::class,
        RegisterUserAction::class,
    ];

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
        $actionFQCN = get_class($event->getController());

        if (in_array($actionFQCN, $this->actions, true)) {
            $token = new Token($event->getRequest()->headers->get('X-Authorization'));

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
