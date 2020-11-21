<?php
declare(strict_types=1);

namespace App\Web\API\Action\Accounts\User;

use App\Modules\Accounts\Application\User\GetToken\GetTokenQuery;
use App\Modules\Accounts\Application\User\SignIn\SignInUserCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Request\Accounts\User\SignInRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class SignInUserAction extends AbstractAction
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $signInUserRequest = SignInRequest::createFromServerRequest($request);

        $this->bus->dispatch(
            new SignInUserCommand($signInUserRequest->getEmail(), $signInUserRequest->getPassword())
        );

        $token = $this->bus
            ->dispatch(new GetTokenQuery($signInUserRequest->getEmail()))
            ->last(HandledStamp::class)
            ->getResult();

        return new JsonResponse([
            'token' => $token->getToken(),
        ]);
    }
}
