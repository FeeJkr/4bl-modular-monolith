<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\SignIn;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Accounts\Application\User\LogicException;
use App\Modules\Accounts\Application\User\NotFoundException;
use App\Modules\Accounts\Application\User\PasswordManager;
use App\Modules\Accounts\Application\User\TokenManager;
use App\Modules\Accounts\Domain\User\UserException;
use App\Modules\Accounts\Domain\User\UserRepository;

final class SignInUserHandler implements CommandHandler
{
    public function __construct(
        private UserRepository $repository,
        private PasswordManager $passwordManager,
        private TokenManager $tokenManager
    ) {}

    /**
     * @throws NotFoundException|LogicException
     */
    public function __invoke(SignInUserCommand $command): void
    {
        $user = $this->repository->fetchByEmail($command->getEmail())
            ?? throw NotFoundException::fromDomainException(UserException::withInvalidCredentials());

        if (! $this->passwordManager->isValid($command->getPassword(), $user->getPassword())) {
            throw LogicException::fromDomainException(UserException::withInvalidCredentials());
        }

        $user->signIn($this->tokenManager->generate());

        $this->repository->store($user);
    }
}
