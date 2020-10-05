<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\SignIn;

use App\Modules\Accounts\Application\User\PasswordManager;
use App\Modules\Accounts\Application\User\TokenManager;
use App\Modules\Accounts\Domain\User\UserException;
use App\Modules\Accounts\Domain\User\UserRepository;

final class SignInUserHandler
{
    private UserRepository $repository;
    private PasswordManager $passwordManager;
    private TokenManager $tokenManager;

    public function __construct(
        UserRepository $repository,
        PasswordManager $passwordManager,
        TokenManager $tokenManager
    ) {
        $this->repository = $repository;
        $this->passwordManager = $passwordManager;
        $this->tokenManager = $tokenManager;
    }

    public function __invoke(SignInUserCommand $command): void
    {
        $user = $this->repository->fetchByEmail($command->getEmail());

        if ($user === null) {
            throw UserException::withInvalidCredentials();
        }

        if (! $this->passwordManager->isValid($command->getPassword(), $user->getPassword())) {
            throw UserException::withInvalidCredentials();
        }

        $user->signIn($this->tokenManager->generate());

        $this->repository->save($user);
    }
}
