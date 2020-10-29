<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\User\GetUserIdByToken;

use App\Modules\Finances\Domain\User\Token;
use App\Modules\Finances\Domain\User\UserRepository;

final class GetUserIdByTokenHandler
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(GetUserIdByTokenQuery $query): int
    {
        return $this->repository
            ->fetchIdByToken(new Token($query->getToken()))
            ->toInt();
    }
}