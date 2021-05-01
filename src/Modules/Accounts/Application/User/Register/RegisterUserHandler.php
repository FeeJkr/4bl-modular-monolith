<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\Register;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Accounts\Application\User\PasswordManager;
use App\Modules\Accounts\Application\User\ValidationException;
use App\Modules\Accounts\Domain\User\User;
use App\Modules\Accounts\Domain\User\UserRepository;

final class RegisterUserHandler implements CommandHandler
{
    public function __construct(
        private UserRepository $repository,
        private PasswordManager $passwordManager,
        private RegisterUserValidator $validator
    ) {}

    /**
     * @throws ValidationException
     */
    public function __invoke(RegisterUserCommand $command): void
    {
        $this->validator->validate($command);

        $user = User::register(
            $command->getEmail(),
            $command->getUsername(),
            $this->passwordManager->hash($command->getPassword())
        );

        $this->repository->store($user);
    }
}
