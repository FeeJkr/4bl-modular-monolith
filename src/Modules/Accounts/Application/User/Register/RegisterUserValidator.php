<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\Register;

use App\Modules\Accounts\Application\User\ValidationException;
use App\Modules\Accounts\Domain\User\UserException;
use App\Modules\Accounts\Domain\User\UserRepository;

final class RegisterUserValidator
{
    public function __construct(private UserRepository $repository) {}

    /**
     * @throws ValidationException
     */
    public function validate(RegisterUserCommand $command): void
    {
        $this->validateUsername($command->getUsername());
        $this->validateEmail($command->getEmail());
        $this->validatePassword($command->getPassword());
        $this->validateUniqueUser($command->getEmail(), $command->getUsername());
    }

    /**
     * @throws ValidationException
     */
    private function validateUsername(string $username): void
    {
        $length = mb_strlen($username);

        if ($length < 5 || $length > 250) {
            throw ValidationException::invalidUsername();
        }
    }

    /**
     * @throws ValidationException
     */
    private function validateEmail(string $email): void
    {
        $length = mb_strlen($email);

        if ($length > 250 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw ValidationException::invalidEmail();
        }
    }

    /**
     * @throws ValidationException
     */
    private function validatePassword(string $password): void
    {
        $length = mb_strlen($password);

        if ($length < 8 || $length > 250) {
            throw ValidationException::invalidPassword();
        }
    }

    /**
     * @throws ValidationException
     */
    private function validateUniqueUser(string $email, string $username): void
    {
        if ($this->repository->existsByEmailOrUsername($email, $username)) {
            throw ValidationException::fromDomainException(UserException::alreadyExists());
        }
    }
}
