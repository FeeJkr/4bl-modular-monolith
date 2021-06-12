<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\SignOut;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Accounts\Application\User\ApplicationException;
use App\Modules\Accounts\Domain\DomainException;
use App\Modules\Accounts\Domain\User\Token;
use App\Modules\Accounts\Domain\User\UserRepository;
use App\Modules\Accounts\Domain\User\UserService;

final class SignOutUserHandler implements CommandHandler
{
    public function __construct(private UserRepository $repository, private UserService $service) {}

    /**
     * @throws ApplicationException
     */
    public function __invoke(SignOutUserCommand $command): void
    {
        try {
            $user = $this->service->signOut(new Token($command->getToken()));

            $this->repository->store($user);
        } catch (DomainException $exception) {
            throw ApplicationException::fromDomainException($exception);
        }
    }
}
