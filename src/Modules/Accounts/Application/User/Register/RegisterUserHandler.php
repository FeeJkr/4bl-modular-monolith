<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\Register;

use App\Modules\Accounts\Application\User\PasswordManager;
use App\Modules\Accounts\Application\User\TokenManager;
use App\Modules\Accounts\Domain\User\User;
use App\Modules\Accounts\Domain\User\UserRepository;

final class RegisterUserHandler
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

    public function __invoke(RegisterUserCommand $command)
    {
        $user = User::register(
            $command->getEmail(),
            $command->getUsername(),
            $this->passwordManager->hash($command->getPassword())
        );

        $this->repository->store($user);
    }
}
