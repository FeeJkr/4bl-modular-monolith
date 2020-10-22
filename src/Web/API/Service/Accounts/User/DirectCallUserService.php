<?php
declare(strict_types=1);

namespace App\Web\API\Service\Accounts\User;

use App\Modules\Accounts\Application\User\GetToken\GetTokenQuery;
use App\Modules\Accounts\Application\User\GetToken\TokenDTO;
use App\Modules\Accounts\Application\User\Register\RegisterUserCommand;
use App\Modules\Accounts\Application\User\SignIn\SignInUserCommand;
use App\Web\API\Request\Accounts\User\RegisterRequest;
use App\Web\API\Request\Accounts\User\SignInRequest;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Throwable;

final class DirectCallUserService implements UserService
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function signIn(SignInRequest $request): string
    {
        $email = $request->getEmail();
        $password = $request->getPassword();

        $command = new SignInUserCommand($email, $password);

        $this->bus->dispatch($command);

        $query = new GetTokenQuery($email);

        /**@var TokenDTO $tokenDTO */
        $tokenDTO = $this->bus
            ->dispatch($query)
            ->last(HandledStamp::class)
            ->getResult();

        return $tokenDTO->getToken();
    }

    public function register(RegisterRequest $request): void
    {
        try {
            $command = new RegisterUserCommand(
                $request->getEmail(),
                $request->getUsername(),
                $request->getPassword()
            );

            $this->bus->dispatch($command);
        } catch (Throwable $exception) {
            throw UserRegistrationErrorException::create($exception);
        }
    }
}
