<?php
declare(strict_types=1);

namespace App\Web\API\Accounts\User;

use App\Modules\Accounts\Application\User\FetchToken\FetchTokenQuery;
use App\Modules\Accounts\Application\User\FetchToken\TokenDTO;
use App\Modules\Accounts\Application\User\SignIn\SignInUserCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class SignInUserAction
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $command = new SignInUserCommand(
            $request->get('email'),
            $request->get('password')
        );

        $this->bus->dispatch($command);

        $query = new FetchTokenQuery(
            $request->get('email')
        );

        /**@var TokenDTO $tokenDTO */
        $tokenDTO = $this->bus
            ->dispatch($query)
            ->last(HandledStamp::class)
            ->getResult();

        return new JsonResponse([
            'token' => $tokenDTO->getToken(),
        ]);
    }
}
