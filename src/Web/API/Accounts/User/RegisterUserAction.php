<?php
declare(strict_types=1);

namespace App\Web\API\Accounts\User;

use App\Modules\Accounts\Application\User\Register\RegisterUserCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

final class RegisterUserAction
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $command = new RegisterUserCommand(
            $request->get('email'),
            $request->get('username'),
            $request->get('password')
        );

        $this->bus->dispatch($command);

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
