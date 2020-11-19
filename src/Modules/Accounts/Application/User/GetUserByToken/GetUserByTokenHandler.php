<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\GetUserByToken;

use App\Modules\Accounts\Domain\User\Token;
use App\Modules\Accounts\Domain\User\UserRepository;

final class GetUserByTokenHandler
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(GetUserByTokenQuery $query): UserDTO
    {
        $token = new Token($query->getToken());

        $user = $this->repository->fetchByToken($token);

        return new UserDTO(
            $user->getId()->toInt(),
            $user->getEmail(),
            $user->getUsername(),
            $user->getPassword(),
            $user->getToken()->toString()
        );
    }
}
