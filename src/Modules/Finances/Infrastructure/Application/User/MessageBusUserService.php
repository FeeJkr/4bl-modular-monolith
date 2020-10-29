<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\Application\User;

use App\Modules\Finances\Application\User\GetUserIdByToken\GetUserIdByTokenQuery;
use App\Modules\Finances\Application\User\UserContract;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class MessageBusUserService implements UserContract
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function getUserIdByToken(GetUserIdByTokenQuery $query): int
    {
        return $this->bus->dispatch($query)
            ->last(HandledStamp::class)
            ->getResult();
    }
}
