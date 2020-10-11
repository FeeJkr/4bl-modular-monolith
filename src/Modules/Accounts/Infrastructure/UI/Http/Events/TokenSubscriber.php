<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\UI\Http\Events;

use App\Modules\Accounts\Application\User\FetchByToken\FetchUserByTokenQuery;
use App\Modules\Accounts\Application\User\TokenManager;
use App\Modules\Accounts\Domain\User\Token;
use App\Modules\Accounts\Domain\User\UserId;
use App\Modules\Accounts\Infrastructure\UI\Http\Api\User\RegisterUserAction;
use App\Modules\Accounts\Infrastructure\UI\Http\Api\User\SignInUserAction;
use App\Modules\Accounts\Infrastructure\UI\Http\Web\User\RegisterUserAction as WebRegisterUserAction;
use App\Modules\Accounts\Infrastructure\UI\Http\Web\User\RenderDashboardPageAction;
use App\Modules\Accounts\Infrastructure\UI\Http\Web\User\SignInUserAction as WebSignInUserAction;
use App\Modules\Accounts\Infrastructure\UI\Http\Web\User\SignOutUserAction as WebSignOutUserAction;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ErrorController;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class TokenSubscriber implements EventSubscriberInterface
{
    private TokenManager $tokenManager;
    private MessageBusInterface $bus;
    private UrlGeneratorInterface $urlGenerator;

    private array $allowedActions = [
        RegisterUserAction::class,
        SignInUserAction::class,
        WebSignInUserAction::class,
        WebRegisterUserAction::class,
    ];

    private array $webActions = [
        WebSignInUserAction::class,
        WebSignOutUserAction::class,
        WebRegisterUserAction::class,
        RenderDashboardPageAction::class,
    ];

    public function __construct(TokenManager $tokenManager, MessageBusInterface $bus, UrlGeneratorInterface $urlGenerator)
    {
        $this->tokenManager = $tokenManager;
        $this->bus = $bus;
        $this->urlGenerator = $urlGenerator;
    }

    public function onKernelController(ControllerEvent $event): void
    {
        if ($event->getController() instanceof ErrorController) {
            return;
        }

        $actionFQCN = get_class($event->getController());
        $isWebAction = in_array($actionFQCN, $this->webActions);
        $isAllowedAction = in_array($actionFQCN, $this->allowedActions);

        $jwtToken = $isWebAction
            ? new Token($event->getRequest()->getSession()->get('user.token'))
            : new Token($event->getRequest()->headers->get('X-Authorization'));

        if ($isAllowedAction) {
            if (! $jwtToken->isNull() && $isWebAction) {
                $this->redirectToDashboard($event);
            }

            return;
        }

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
        } else {
            if ($isWebAction) {
                $this->redirectToSignIn($event);
            } else {
                $this->forbiddenResponse($event);
            }
        }
    }

    private function forbiddenResponse(ControllerEvent $event): void
    {
        $event->setController(static function (): Response {
            return new JsonResponse(['error' => 'Authentication error.'], Response::HTTP_FORBIDDEN);
        });
    }

    private function redirectToDashboard(ControllerEvent $event): void
    {
        $event->setController(function (): Response {
            return new RedirectResponse($this->urlGenerator->generate('dashboard'));
        });
    }

    private function redirectToSignIn(ControllerEvent $event): void
    {
        $event->setController(function (): Response {
            return new RedirectResponse($this->urlGenerator->generate('sign-in'));
        });
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
