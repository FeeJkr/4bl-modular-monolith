<?php
declare(strict_types=1);

namespace App\Web\API\Service\Finances\User;

use App\Modules\Finances\Application\User\GetUserIdByToken\GetUserIdByTokenQuery;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class DirectCallUserService implements UserService
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function getUserIdByToken(string $token): int
    {
        return $this->bus
            ->dispatch(new GetUserIdByTokenQuery($token))
            ->last(HandledStamp::class)
            ->getResult();
    }
}
