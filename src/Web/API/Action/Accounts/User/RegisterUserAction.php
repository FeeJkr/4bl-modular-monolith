<?php
declare(strict_types=1);

namespace App\Web\API\Action\Accounts\User;

use App\Modules\Accounts\Application\User\Register\RegisterUserCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Request\Accounts\User\RegisterRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;

final class RegisterUserAction extends AbstractAction
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $registerUserRequest = RegisterRequest::createFromServerRequest($request);

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
