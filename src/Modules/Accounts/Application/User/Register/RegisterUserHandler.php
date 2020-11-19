<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\Register;

use App\Modules\Accounts\Application\User\PasswordManager;
use App\Modules\Accounts\Application\User\TokenManager;
use App\Modules\Accounts\Domain\User\User;
use App\Modules\Accounts\Domain\User\UserException;
use App\Modules\Accounts\Domain\User\UserRepository;

final class RegisterUserHandler
{
    private UserRepository $repository;
    private PasswordManager $passwordManager;
    private TokenManager $tokenManager;

    public function __construct(
        UserRepository $repository,
        PasswordManager $passwordManager
    ) {
        $this->repository = $repository;
        $this->passwordManager = $passwordManager;
    }

    public function __invoke(RegisterUserCommand $command): void
    {
        if ($this->repository->existsByEmailOrUsername($command->getEmail(), $command->getUsername())) {
            throw UserException::alreadyExists();
        }

        $user = User::register(
            $command->getEmail(),
            $command->getUsername(),
            $this->passwordManager->hash($command->getPassword())
        );

        $this->repository->store($user);
    }
}
