<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\UI\Http\Events;

use App\Modules\Accounts\Application\User\FetchByToken\FetchUserByTokenQuery;
use App\Modules\Accounts\Application\User\FetchByToken\UserDTO;
use App\Modules\Accounts\Application\User\TokenManager;
use App\Modules\Accounts\Domain\User\Token;
use App\Modules\Accounts\Domain\User\UserId;
use App\Modules\Accounts\Infrastructure\UI\Http\Api\User\RegisterUserAction;
use App\Modules\Accounts\Infrastructure\UI\Http\Api\User\SignInUserAction;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ErrorController;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class TokenSubscriber implements EventSubscriberInterface
{
    private TokenManager $tokenManager;
    private MessageBusInterface $bus;

    private array $allowedActions = [
        RegisterUserAction::class,
        SignInUserAction::class
    ];

    public function __construct(TokenManager $tokenManager, MessageBusInterface $bus)
    {
        $this->tokenManager = $tokenManager;
        $this->bus = $bus;
    }

    public function onKernelController(ControllerEvent $event): void
    {
        if ($event->getController() instanceof ErrorController) {
            return;
        }

        if (in_array(get_class($event->getController()), $this->allowedActions)) {
            return;
        }

        $jwtToken = new Token($event->getRequest()->headers->get('X-Authorization'));

        if ($this->tokenManager->isValid($jwtToken)) {
            /** @var UserId $userId */
            $userId = $this->bus
                ->dispatch(new FetchUserByTokenQuery($jwtToken))
                ->last(HandledStamp::class)
                ->getResult();

            if ($userId->isNull()) {
                $this->forbiddenResponse($event);

                return;
            }

            $event->getRequest()->request->set('user_id', $userId->toInt());

            return;
        }

        $this->forbiddenResponse($event);
    }

    private function forbiddenResponse(ControllerEvent $event): void
    {
        $event->setController(static function (): Response {
            return new JsonResponse(['error' => 'Authentication error.'], Response::HTTP_FORBIDDEN);
        });
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
