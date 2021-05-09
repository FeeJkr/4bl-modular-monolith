<?php

declare(strict_types=1);

namespace App\Web\API\Action\Accounts\User\GetMyUserData;

use App\Common\Application\Query\QueryBus;
use App\Common\Infrastructure\Request\HttpRequestContext;
use App\Modules\Accounts\Application\User\GetUserByToken\GetUserByTokenQuery;
use App\Modules\Accounts\Application\User\GetUserByToken\UserDTO;
use App\Web\API\Action\AbstractAction;
use Symfony\Component\HttpFoundation\Response;

class GetMyUserDataAction extends AbstractAction
{
    public function __construct(private QueryBus $bus, private HttpRequestContext $requestContext){}

    public function __invoke(): Response
    {
        /** @var UserDTO $user */
        $user = $this->bus->handle(
            new GetUserByTokenQuery($this->requestContext->getUserToken())
        );

        return $this->json([
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'username' => $user->getUsername(),
        ]);
    }
}