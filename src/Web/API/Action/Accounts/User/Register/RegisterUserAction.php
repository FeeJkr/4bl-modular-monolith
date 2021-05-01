<?php
declare(strict_types=1);

namespace App\Web\API\Action\Accounts\User\Register;

use App\Common\Application\Command\CommandBus;
use App\Modules\Accounts\Application\User\Register\RegisterUserCommand;
use App\Web\API\Action\AbstractAction;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;

final class RegisterUserAction extends AbstractAction
{
    public function __construct(private CommandBus $bus){}

    public function __invoke(Request $request): JsonResponse
    {
        $registerUserRequest = RegisterUserRequest::createFromServerRequest($request);

        $this->bus->dispatch(
            new RegisterUserCommand(
                $registerUserRequest->getEmail(),
                $registerUserRequest->getUsername(),
                $registerUserRequest->getPassword()
            )
        );

        return $this->noContentResponse();
    }
}
