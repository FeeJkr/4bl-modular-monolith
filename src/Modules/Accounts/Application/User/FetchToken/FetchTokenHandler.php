<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\FetchToken;

use App\Modules\Accounts\Domain\User\UserException;
use App\Modules\Accounts\Domain\User\UserRepository;

final class FetchTokenHandler
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(FetchTokenQuery $query): TokenDTO
    {
        $user = $this->repository->fetchByEmail($query->getEmail());

        if ($user === null || $user->getToken()->isNull()) {
            throw UserException::withInvalidCredentials();
        }

        return new TokenDTO(
            $user->getToken()->toString()
        );
    }
}
