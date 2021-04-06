<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\User;

use App\Common\Infrastructure\Request\HttpRequestContext;
use App\Modules\Accounts\Application\User\GetUserByToken\GetUserByTokenQuery;
use App\Modules\Accounts\Application\User\GetUserByToken\UserDTO;
use App\Modules\Invoices\Domain\User\UserContext as UserContextInterface;
use App\Modules\Invoices\Domain\User\UserId;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class UserContext implements UserContextInterface
{
    private HttpRequestContext $httpRequestContext;
    private MessageBusInterface $bus;

    public function __construct(HttpRequestContext $httpRequestContext, MessageBusInterface $bus)
    {
        $this->httpRequestContext = $httpRequestContext;
        $this->bus = $bus;
    }

    public function getUserId(): UserId
    {
        $token = $this->httpRequestContext->getUserToken();

        /** @var UserDTO $user */
        $user = $this->bus
            ->dispatch(new GetUserByTokenQuery($token))
            ->last(HandledStamp::class)
            ->getResult();

        return UserId::fromInt($user->getId());
    }
}
