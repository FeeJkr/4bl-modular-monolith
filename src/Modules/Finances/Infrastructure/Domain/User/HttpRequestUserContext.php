<?php

declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\Domain\User;

use App\Common\Application\Query\QueryBus;
use App\Common\Infrastructure\Request\HttpRequestContext;
use App\Modules\Accounts\Application\User\GetUserByToken\GetUserByTokenQuery;
use App\Modules\Accounts\Application\User\GetUserByToken\UserDTO;
use App\Modules\Finances\Domain\User\UserContext;
use App\Modules\Finances\Domain\User\UserId;

final class HttpRequestUserContext implements UserContext
{
    public function __construct(private HttpRequestContext $requestContext, private QueryBus $bus){}

    public function getUserId(): UserId
    {
        $token = $this->requestContext->getUserToken();

        /** @var UserDTO $user */
        $user = $this->bus->handle(new GetUserByTokenQuery($token));

        return UserId::fromString($user->getId());
    }
}
