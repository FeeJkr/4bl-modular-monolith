<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\User;

use App\Common\Application\Query\QueryBus;
use App\Common\Infrastructure\Request\HttpRequestContext;
use App\Modules\Accounts\Application\User\GetUserByToken\GetUserByTokenQuery;
use App\Modules\Accounts\Application\User\GetUserByToken\UserDTO;
use App\Modules\Invoices\Domain\User\UserContext as UserContextInterface;
use App\Modules\Invoices\Domain\User\UserId;

final class UserContext implements UserContextInterface
{
    public function __construct(private HttpRequestContext $httpRequestContext, private QueryBus $bus){}

    public function getUserId(): UserId
    {
        $token = $this->httpRequestContext->getUserToken();

        /** @var UserDTO $user */
        $user = $this->bus->handle(new GetUserByTokenQuery($token));

        return UserId::fromString($user->getId());
    }
}
