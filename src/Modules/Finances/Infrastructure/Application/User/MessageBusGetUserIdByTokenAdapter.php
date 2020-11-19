<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\Application\User;

use App\Modules\Accounts\Application\User\GetUserByToken\GetUserByTokenQuery;
use App\Modules\Accounts\Application\User\GetUserByToken\UserDTO;
use App\Modules\Finances\Application\User\GetUserIdByTokenAdapter;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class MessageBusGetUserIdByTokenAdapter implements GetUserIdByTokenAdapter
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function getUserIdByToken(string $token): int
    {
        $query = new GetUserByTokenQuery($token);

        /** @var UserDTO $user */
        $user = $this->bus->dispatch($query)->last(HandledStamp::class)->getResult();

        return $user->getId();
    }
}

