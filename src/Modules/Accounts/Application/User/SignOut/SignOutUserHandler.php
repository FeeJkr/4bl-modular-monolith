<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\SignOut;

use App\Modules\Accounts\Domain\User\UserRepository;

final class SignOutUserHandler
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(SignOutUserCommand $command): void
    {
        $user = $this->repository->fetchByToken($command->getToken());
        $user->signOut();

        $this->repository->save($user);
    }
}
