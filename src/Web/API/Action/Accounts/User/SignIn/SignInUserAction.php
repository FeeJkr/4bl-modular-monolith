<?php

declare(strict_types=1);

namespace App\Web\API\Action\Accounts\User\SignIn;

use App\Common\Application\Command\CommandBus;
use App\Common\Application\Query\QueryBus;
use App\Modules\Accounts\Application\User\GetToken\GetTokenQuery;
use App\Modules\Accounts\Application\User\GetToken\TokenDTO;
use App\Modules\Accounts\Application\User\SignIn\SignInUserCommand;
use App\Web\API\Action\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class SignInUserAction extends AbstractAction
{
    public function __construct(
        private CommandBus $commandBus,
        private QueryBus $queryBus,
    ){}

    public function __invoke(Request $request): Response
    {
        $signInUserRequest = SignInUserRequest::createFromServerRequest($request);

        $this->commandBus->dispatch(
            new SignInUserCommand($signInUserRequest->getEmail(), $signInUserRequest->getPassword())
        );

        /** @var TokenDTO $token */
        $token = $this->queryBus->handle(new GetTokenQuery($signInUserRequest->getEmail()));

        $request->getSession()->set('user.token', $token->getToken());

        return $this->noContentResponse();
    }
}
