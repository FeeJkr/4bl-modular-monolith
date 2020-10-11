<?php
declare(strict_types=1);

namespace App\Web\MVC\Middleware;

use App\Modules\Accounts\Application\User\TokenManager;
use App\Modules\Accounts\Domain\User\Token;
use App\Web\MVC\Action\Accounts\User\RegisterUserAction;
use App\Web\MVC\Action\Accounts\User\SignInUserAction;
use App\Web\MVC\Action\Accounts\User\SignOutUserAction;
use App\Web\MVC\Action\Finances\Category\ShowAllCategoriesAction;
use App\Web\MVC\Action\Finances\ShowFinancesDashboardAction;
use App\Web\MVC\Action\ShowDashboardAction;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use function in_array;

final class TokenMiddleware implements EventSubscriberInterface
{
    private TokenManager $tokenManager;
    private UrlGeneratorInterface $urlGenerator;

    protected array $actions = [
        ShowDashboardAction::class,
        SignInUserAction::class,
        SignOutUserAction::class,
        RegisterUserAction::class,
        ShowFinancesDashboardAction::class,
        ShowAllCategoriesAction::class,
    ];

    protected array $allowedActions = [
        SignInUserAction::class,
        RegisterUserAction::class,
    ];

    public function __construct(TokenManager $tokenManager, UrlGeneratorInterface $urlGenerator)
    {
        $this->tokenManager = $tokenManager;
        $this->urlGenerator = $urlGenerator;
    }

    public function onKernelController(ControllerEvent $event): void
    {
        $actionFQCN = get_class($event->getController());

        if (in_array($actionFQCN, $this->actions, true)) {
            $isAllowedAction = in_array($actionFQCN, $this->allowedActions, true);
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
