<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\SignOut;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Accounts\Domain\User\Token;
use App\Modules\Accounts\Domain\User\UserRepository;

final class SignOutUserHandler implements CommandHandler
{
    public function __construct(private UserRepository $repository) {}

    public function __invoke(SignOutUserCommand $command): void
    {
        $user = $this->repository->fetchByToken(new Token($command->getToken()));
        $user->signOut();

        $this->repository->save($user);
    }
}
