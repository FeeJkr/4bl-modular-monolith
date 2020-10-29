<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\Application\User;

use App\Modules\Accounts\Application\User\GetToken\GetTokenQuery;
use App\Modules\Accounts\Application\User\GetToken\TokenDTO;
use App\Modules\Accounts\Application\User\Register\RegisterUserCommand;
use App\Modules\Accounts\Application\User\SignIn\SignInUserCommand;
use App\Modules\Accounts\Application\User\SignOut\SignOutUserCommand;
use App\Modules\Accounts\Application\User\UserContract;
use App\Modules\Accounts\Application\User\UserContractException;
use App\Modules\Accounts\Domain\User\UserException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class MessageBusUserService implements UserContract
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function getToken(GetTokenQuery $query): TokenDTO
    {
        return $this->bus
            ->dispatch($query)
            ->last(HandledStamp::class)
            ->getResult();
    }

    public function register(RegisterUserCommand $command): void
    {
        try {
            $this->bus->dispatch($command);
        } catch (UserException $exception) {
            throw new UserContractException($exception->getMessage());
        }
    }

    public function signIn(SignInUserCommand $command): void
    {
        $this->bus->dispatch($command);
    }

    public function signOut(SignOutUserCommand $command): void
    {
    }
}
