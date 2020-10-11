<?php
declare(strict_types=1);

namespace App\Common\Web\Middleware;

use App\Common\Web\ShowDashboardAction;
use App\Modules\Accounts\Application\User\TokenManager;
use App\Modules\Accounts\Domain\User\Token;
use App\Modules\Accounts\Infrastructure\UI\Http\Api\User\RegisterUserAction as ApiRegisterUserAction;
use App\Modules\Accounts\Infrastructure\UI\Http\Api\User\SignInUserAction as ApiSignInUserAction;
use App\Modules\Accounts\Infrastructure\UI\Http\Web\User\RegisterUserAction;
use App\Modules\Accounts\Infrastructure\UI\Http\Web\User\SignInUserAction;
use App\Modules\Accounts\Infrastructure\UI\Http\Web\User\SignOutUserAction;
use App\Modules\Finances\Infrastructure\UI\Http\Web\Category\ShowAllCategoriesAction;
use App\Modules\Finances\Infrastructure\UI\Http\Web\ShowFinancesDashboardAction;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ErrorController;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class TokenMiddleware implements EventSubscriberInterface
{
    private TokenManager $tokenManager;
    private MessageBusInterface $bus;
    private UrlGeneratorInterface $urlGenerator;

    protected string $actionFQCN = '';
    protected bool $isAllowedAction = false;

    protected array $webActions = [
        // Common
        ShowDashboardAction::class,

        // Accounts Module
        SignInUserAction::class,
        SignOutUserAction::class,
        RegisterUserAction::class,

        // Finances Module
        ShowFinancesDashboardAction::class,
        ShowAllCategoriesAction::class,
    ];

    protected array $apiActions = [
        // Accounts Module
        ApiSignInUserAction::class,
        ApiRegisterUserAction::class,
    ];

    protected array $allowedActions = [
        SignInUserAction::class,
        RegisterUserAction::class,
        ApiSignInUserAction::class,
        ApiRegisterUserAction::class,
    ];

    public function __construct(TokenManager $tokenManager, MessageBusInterface $bus, UrlGeneratorInterface $urlGenerator)
    {
        $this->tokenManager = $tokenManager;
        $this->bus = $bus;
        $this->urlGenerator = $urlGenerator;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }

    public function onKernelController(ControllerEvent $event): void
    {
        $this->actionFQCN = get_class($event->getController());
        $this->isAllowedAction = in_array($this->actionFQCN, $this->allowedActions);

        if ($this->actionFQCN === ErrorController::class) {
            return;
        }

        if (in_array($this->actionFQCN, $this->webActions)) {
            $this->processWeb($event);

            return;
        }

        $this->processApi($event);
    }

    private function processWeb(ControllerEvent $event): void
    {
        $token = new Token($event->getRequest()->getSession()->get('user.token'));

        if ($this->tokenManager->isValid($token)) {
            if ($this->isAllowedAction) {
                $event->setController(function (): Response {
                    return new RedirectResponse($this->urlGenerator->generate('dashboard'));
                });
            }

            return;
        }

        // if token is invalid and we in allowed action
        if (in_array($this->actionFQCN, $this->allowedActions)) {
            return;
        }

        // if token is invalid and we in blocked action
        $event->setController(function (): Response {
            return new RedirectResponse($this->urlGenerator->generate('sign-in'));
        });
    }

    private function processApi(ControllerEvent $event): void
    {
        $token = new Token($event->getRequest()->headers->get('X-Authorization'));

        $event->setController(static function (): Response {
            return new JsonResponse(['error' => 'Authentication error.'], Response::HTTP_FORBIDDEN);
        });
    }
}
