<?php
declare(strict_types=1);

namespace App\Web\API\Service\Accounts\User;

use App\Modules\Accounts\Application\User\GetToken\GetTokenQuery;
use App\Modules\Accounts\Application\User\Register\RegisterUserCommand;
use App\Modules\Accounts\Application\User\SignIn\SignInUserCommand;
use App\Modules\Accounts\Application\User\UserContract;
use App\Modules\Accounts\Application\User\UserContractException;
use App\Web\API\Request\Accounts\User\RegisterRequest;
use App\Web\API\Request\Accounts\User\SignInRequest;

final class DirectCallUserService implements UserService
{
    private UserContract $userContract;

    public function __construct(UserContract $userContract)
    {
        $this->userContract = $userContract;
    }

    public function signIn(SignInRequest $request): string
    {
        $email = $request->getEmail();
        $password = $request->getPassword();

        $this->userContract->signIn(
            new SignInUserCommand($email, $password)
        );

        $tokenDTO = $this->userContract->getToken(
            new GetTokenQuery($email)
        );

        return $tokenDTO->getToken();
    }

    public function register(RegisterRequest $request): void
    {
        try {
            $command = new RegisterUserCommand(
                $request->getEmail(),
                $request->getUsername(),
                $request->getPassword()
            );

            $this->userContract->register($command);
        } catch (UserContractException $exception) {
            throw new UserRegistrationErrorException($exception->getMessage());
        }
    }
}
