<?php
declare(strict_types=1);

namespace App\Web\API\Service\Finances\User;

use App\Modules\Finances\Application\User\FetchUserIdByToken\FetchUserIdByTokenQuery;
use App\Modules\Finances\Domain\User\Token;
use App\Modules\Finances\Domain\User\UserId;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class DirectCallUserService implements UserService
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function getUserIdByToken(Token $token): UserId
    {
        return $this->bus
            ->dispatch(new FetchUserIdByTokenQuery($token))
            ->last(HandledStamp::class)
            ->getResult();
    }
}
