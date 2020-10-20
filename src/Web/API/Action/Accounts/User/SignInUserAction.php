<?php
declare(strict_types=1);

namespace App\Web\API\Action\Accounts\User;

use App\Web\API\Action\AbstractAction;
use App\Web\API\Request\Accounts\User\SignInRequest;
use App\Web\API\Service\Accounts\User\UserService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class SignInUserAction extends AbstractAction
{
    private UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $request = SignInRequest::createFromServerRequest($request);

        $token = $this->service->signIn($request);

        return new JsonResponse([
            'token' => $token,
        ]);
    }
}
