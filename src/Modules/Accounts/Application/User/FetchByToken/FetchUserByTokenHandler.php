<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\FetchByToken;

use App\Modules\Accounts\Domain\User\UserId;
use App\Modules\Accounts\Domain\User\UserRepository;

final class FetchUserByTokenHandler
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(FetchUserByTokenQuery $query): UserId
    {
        return $this->repository->fetchIdByToken($query->getToken());
    }
}
