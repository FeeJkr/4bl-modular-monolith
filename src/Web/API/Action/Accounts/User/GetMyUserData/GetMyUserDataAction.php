<?php

declare(strict_types=1);

namespace App\Web\API\Action\Accounts\User\GetMyUserData;

use App\Common\Application\Query\QueryBus;
use App\Common\Infrastructure\Request\HttpRequestContext;
use App\Modules\Accounts\Application\User\GetUserByToken\GetUserByTokenQuery;
use App\Modules\Accounts\Application\User\GetUserByToken\UserDTO;
use App\Web\API\Action\AbstractAction;

class GetMyUserDataAction extends AbstractAction
{
    public function __construct(private QueryBus $bus, private HttpRequestContext $requestContext){}

    public function __invoke(): GetMyUserDataResponse
    {
        /** @var UserDTO $user */
        $user = $this->bus->handle(
            new GetUserByTokenQuery($this->requestContext->getUserToken())
        );

        return GetMyUserDataResponse::respond($user);
    }
}