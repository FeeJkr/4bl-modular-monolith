<?php

declare(strict_types=1);

namespace App\Web\API\Action\Accounts\User\SignIn;

use App\Common\Application\Command\CommandBus;
use App\Common\Application\Query\QueryBus;
use App\Modules\Accounts\Application\User\GetToken\GetTokenQuery;
use App\Modules\Accounts\Application\User\GetToken\TokenDTO;
use App\Modules\Accounts\Application\User\SignIn\SignInUserCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\NoContentResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class SignInUserAction extends AbstractAction
{
    public function __construct(
        private CommandBus $commandBus,
        private QueryBus $queryBus,
        private SessionInterface $session
    ){}

    public function __invoke(SignInUserRequest $request): NoContentResponse
    {
        $this->commandBus->dispatch(
            new SignInUserCommand($request->getEmail(), $request->getPassword())
        );

        /** @var TokenDTO $token */
        $token = $this->queryBus->handle(new GetTokenQuery($request->getEmail()));

        $this->session->set('user.token', $token->getToken());

        return NoContentResponse::respond();
    }
}
