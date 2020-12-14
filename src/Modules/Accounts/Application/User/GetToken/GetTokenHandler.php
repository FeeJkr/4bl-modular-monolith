<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\GetToken;

use App\Modules\Accounts\Application\User\LogicException;
use App\Modules\Accounts\Application\User\NotFoundException;
use App\Modules\Accounts\Domain\User\UserException;
use App\Modules\Accounts\Domain\User\UserRepository;

final class GetTokenHandler
{
    public function __construct(private UserRepository $repository) {}

    /**
     * @throws LogicException|NotFoundException
     */
    public function __invoke(GetTokenQuery $query): TokenDTO
    {
        $user = $this->repository->fetchByEmail($query->getEmail())
            ?? throw NotFoundException::fromDomainException(UserException::withInvalidCredentials());

        if ($user->getToken()->isNull()) {
            throw LogicException::fromDomainException(UserException::withInvalidCredentials());
        }

        return new TokenDTO(
            $user->getToken()->toString()
        );
    }
}
