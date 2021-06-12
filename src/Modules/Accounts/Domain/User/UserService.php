<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Domain\User;

final class UserService
{
    public function __construct(
        private TokenManager $tokenManager,
        private ValidPasswordSpecification $validPasswordSpecification,
        private EmailAndUsernameNotExistsSpecification $alreadyExistsSpecification,
        private UserRepository $repository,
        private PasswordManager $passwordManager,
    ){}

    /**
     * @throws UserException
     */
    public function register(string $email, string $username, string $password): User
    {
        if (! $this->alreadyExistsSpecification->isSatisfiedBy($email, $username)) {
            throw UserException::alreadyExists();
        }

        return User::register(
            $email,
            $username,
            $this->passwordManager->hash($password),
        );
    }

    /**
     * @throws UserException
     */
    public function signIn(string $email, string $password): User
    {
        $user = $this->repository->fetchByEmail($email) ?? throw UserException::notFoundByEmail($email);

        if (! $this->validPasswordSpecification->isSatisfiedBy($password, $user->getPassword())) {
            throw UserException::withInvalidCredentials();
        }

        $user->signIn($this->tokenManager->generate());

        return $user;
    }

    /**
     * @throws UserException
     */
    public function signOut(Token $token): User
    {
        $user = $this->repository->fetchByToken($token) ?? throw UserException::notFoundByToken($token);

        $user->signOut();

        return $user;
    }
}