<?php
declare(strict_types=1);

namespace App\Web\API\Action\Accounts\User\SignIn;

use App\Modules\Accounts\Application\User\GetToken\GetTokenQuery;
use App\Modules\Accounts\Application\User\GetToken\TokenDTO;
use App\Modules\Accounts\Application\User\SignIn\SignInUserCommand;
use App\Web\API\Action\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class SignInUserAction extends AbstractAction
{
    public function __construct(private MessageBusInterface $bus, private SignInUserResponder $responder){}

    public function __invoke(Request $request): Response
    {
        $signInUserRequest = SignInUserRequest::createFromServerRequest($request);

        $this->bus->dispatch(
            new SignInUserCommand($signInUserRequest->getEmail(), $signInUserRequest->getPassword())
        );

        /** @var TokenDTO $token */
        $token = $this->bus
            ->dispatch(new GetTokenQuery($signInUserRequest->getEmail()))
            ->last(HandledStamp::class)
            ->getResult();

        $request->getSession()->set('user.token', $token);

        return $this->responder->respond($request, $token);
    }
}
