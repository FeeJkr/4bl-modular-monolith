<?php
declare(strict_types=1);

namespace App\Web\API\Action\Accounts\User;

use App\Web\API\Action\AbstractAction;
use App\Web\API\Request\Accounts\User\RegisterRequest;
use App\Web\API\Service\Accounts\User\UserRegistrationErrorException;
use App\Web\API\Service\Accounts\User\UserService;
use Assert\LazyAssertionException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class RegisterUserAction extends AbstractAction
{
    private UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $registerUserRequest = RegisterRequest::createFromServerRequest($request);

            $this->service->register($registerUserRequest);

            return $this->noContentResponse();
        } catch (UserRegistrationErrorException $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (LazyAssertionException $validationException) {
            $errors = [];

            foreach ($validationException->getErrorExceptions() as $exception) {
                $errors[$exception->getPropertyPath()] = $exception->getMessage();
            }

            return new JsonResponse(['error' => $errors], Response::HTTP_BAD_REQUEST);
        }
    }
}
